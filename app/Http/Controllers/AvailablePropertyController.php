<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AvailableProperty;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AvailablePropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = AvailableProperty::where('is_active', true)
            ->whereIn('status', ['approved', 'under offer']);

        // Price Filter (Using portal_sale_price as it's the investor's cost)
        if ($request->filled('min_price')) {
            $query->where('portal_sale_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('portal_sale_price', '<=', $request->max_price);
        }

        // Beds & Baths
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '=', $request->bedrooms);
        }
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '=', $request->bathrooms);
        }

        // Property Category (Parent)
        if ($request->filled('property_type')) {
            $query->where('property_type_id', $request->property_type);
        }

        // Property Type (Specific Unit Type)
        if ($request->filled('unit_type')) {
            $query->where('unit_type_id', $request->unit_type);
        }

        // Investment Strategy
        if ($request->filled('investment_strategy')) {
            $query->where('investment_type', $request->investment_strategy);
        }

        // Tenure
        if ($request->filled('tenure')) {
            $query->where('tenure_type', $request->tenure);
        }

        // Location & Radius Search
        if ($request->filled('lat') && $request->filled('lng') && $request->filled('radius')) {
            $lat = $request->lat;
            $lng = $request->lng;
            $radius = $request->radius; // in miles

            $query->selectRaw("available_properties.*, ( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$lat, $lng, $lat])
                ->having("distance", "<=", $radius);
        } elseif ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $properties = $query->with(['propertyType', 'marketingPurpose', 'unitType'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $propertyTypes = \App\Models\PropertyType::all();
        $unitTypes = \App\Models\UnitType::all();

        return view('available_properties.index', compact('properties', 'propertyTypes', 'unitTypes'));
    }

    public function agentProperties()
    {
        $properties = AvailableProperty::with(['propertyType', 'marketingPurpose', 'owner'])
            ->whereHas('owner', function ($q) {
                $q->where('role', 'agent');
            })
            ->latest()
            ->paginate(10);

        return view('admin.available_properties.agents_list', compact('properties'));
    }

    public function adminIndex(Request $request)
    {
        $query = AvailableProperty::with(['propertyType', 'marketingPurpose', 'owner']);

        // Basic Filter for Agents (Only see own)
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        // Search Filter (Headline or Location)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('headline', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('postcode', 'like', "%{$search}%");
            });
        }

        // Property Type Filter
        if ($request->filled('property_type')) {
            $query->where('property_type_id', $request->property_type);
        }

        // Marketing Purpose Filter
        if ($request->filled('purpose')) {
            $query->where('marketing_purpose_id', $request->purpose);
        }

        // Price Range Filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Status Filter
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'draft') {
                $query->where('status', 'draft');
            } elseif ($status === 'published') {
                $query->where('status', 'approved');
            } elseif ($status === 'sold') {
                $query->where('status', 'sold out');
            } elseif ($status === 'under_offer') {
                $query->where('status', 'under offer');
            } else {
                $query->where('status', $status);
            }
        }

        $properties = $query->latest()->paginate(15)->withQueryString();

        $otherAgents = \App\Models\User::where('role', 'agent')
            ->where('id', '!=', Auth::id())
            ->get();

        $propertyTypes = \App\Models\PropertyType::all();
        $marketingPurposes = \App\Models\MarketingPurpose::all();

        return view('admin.available_properties.index', compact('properties', 'otherAgents', 'propertyTypes', 'marketingPurposes'));
    }

    public function create()
    {
        $propertyTypes = \App\Models\PropertyType::all();
        $marketingPurposes = \App\Models\MarketingPurpose::all();
        $unitTypes = \App\Models\UnitType::all();
        $features = \App\Models\Feature::all();

        return view('available_properties.create', compact('propertyTypes', 'marketingPurposes', 'unitTypes', 'features'));
    }

    public function store(Request $request, \App\Services\PropertyMatchingService $matchingService)
    {
        $request->validate([
            'headline' => 'required|string|max:255',
            'property_title' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'door_number' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'market_value_min' => 'nullable|numeric',
            'market_value_max' => 'nullable|numeric',
            'market_value_avg' => 'nullable|numeric',
            'property_type_id' => 'required|exists:property_types,id',
            'marketing_purpose_id' => 'required|exists:marketing_purposes,id',
            'unit_type_id' => 'nullable|exists:unit_types,id',
            'full_description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:20480',
            'status' => 'nullable|string|in:pending,approved,disapproved,sold out,under offer,draft',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'investment_type' => 'nullable|string',
            'financing_type' => 'nullable|string',
            'is_cash_buy' => 'nullable|boolean',
            'exchange_deadline' => 'nullable|string',
            'completion_deadline' => 'nullable|string',
            'assignable_contract' => 'nullable|string',
            'tenure_type' => 'nullable|string',
            'share_of_freehold' => 'nullable|string',
            'lease_years_remaining' => 'nullable|integer',
            'monthly_rent' => 'nullable|numeric',
            'yearly_rent' => 'nullable|numeric',
            'is_currently_rented' => 'nullable|boolean',
        ]);

        $data = $request->except(['thumbnail', 'gallery_images', 'features', 'video', 'costs', 'tenants']);

        // Platform Fee Calculation (Flat 2%)
        if (isset($data['price'])) {
            $vendorPrice = (float) $data['price'];
            $psgFee = $vendorPrice * 0.02;
            $data['psg_fees'] = $psgFee;
            $data['portal_sale_price'] = $vendorPrice + $psgFee;
            // Note: Vendor Sale Price is stored in 'price' field.
        }

        $data['discount_available'] = $request->has('discount_available');
        $data['is_currently_rented'] = $request->has('is_currently_rented');

        // Status Security
        if (auth()->user()->role === 'admin') {
            $data['status'] = $request->status ?? 'pending';
        } else {
            if ($request->has('status') && in_array($request->status, ['pending', 'draft', 'sold out', 'under offer'])) {
                $data['status'] = $request->status;
            } else {
                $data['status'] = 'pending';
            }
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('properties/thumbnails', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $images = [];
            foreach ($request->file('gallery_images') as $image) {
                $images[] = $image->store('properties/gallery', 'public');
            }
            $data['gallery_images'] = $images;
        }

        if ($request->hasFile('video')) {
            $data['video_url'] = $request->file('video')->store('properties/videos', 'public');
        }

        $data['user_id'] = Auth::id();

        $property = AvailableProperty::create($data);

        // Notify matching service
        $matchingService = app(\App\Services\PropertyMatchingService::class);
        $matchingService->findMatchesForProperty($property);

        // Sync features
        if ($request->has('features')) {
            $property->features()->sync($request->features);
        }

        // Save Costs
        if ($request->has('costs')) {
            foreach ($request->costs as $cost) {
                if (!empty($cost['name']) && !empty($cost['amount'])) {
                    $property->costs()->create([
                        'name' => $cost['name'],
                        'amount' => $cost['amount'],
                    ]);
                }
            }
        }

        // Save Tenants
        if ($request->has('tenants')) {
            foreach ($request->tenants as $tenant) {
                if (!empty($tenant['name'])) {
                    $property->tenants()->create([
                        'name' => $tenant['name'],
                        'phone' => $tenant['phone'] ?? null,
                        'email' => $tenant['email'] ?? null,
                        'is_primary' => isset($tenant['is_primary']),
                    ]);
                }
            }
        }

        // Notify Admin (webleads) for any new property added
        try {
            $adminEmail = 'webleads@propertysourcinggroup.co.uk';
            $data = [
                'agent_name' => auth()->user()->name,
                'property_title' => $property->headline,
                'property_location' => $property->location,
                'property_price' => $property->portal_sale_price ?? $property->price,
                'property_url' => route('available-properties.show', $property->id),
            ];

            \Illuminate\Support\Facades\Mail::send('emails.admin_new_property', $data, function ($message) use ($adminEmail, $property) {
                $message->to($adminEmail)
                    ->subject('New Property Listed: ' . $property->headline);
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send admin notification for new property: ' . $e->getMessage());
        }

        return redirect()->route('admin.available-properties.index')->with('success', 'Property added successfully');
    }

    public function edit($id)
    {
        $property = AvailableProperty::findOrFail($id);
        $propertyTypes = \App\Models\PropertyType::all();
        $marketingPurposes = \App\Models\MarketingPurpose::all();
        $unitTypes = \App\Models\UnitType::all();
        $features = \App\Models\Feature::all();
        $selectedFeatures = $property->features->pluck('id')->toArray();

        return view('admin.available_properties.edit', compact('property', 'propertyTypes', 'marketingPurposes', 'unitTypes', 'features', 'selectedFeatures'));
    }

    public function update(Request $request, $id, \App\Services\PropertyMatchingService $matchingService)
    {
        $property = AvailableProperty::findOrFail($id);

        $request->validate([
            'headline' => 'required|string|max:255',
            'property_title' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'door_number' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'market_value_min' => 'nullable|numeric',
            'market_value_max' => 'nullable|numeric',
            'market_value_avg' => 'nullable|numeric',
            'property_type_id' => 'required|exists:property_types,id',
            'marketing_purpose_id' => 'required|exists:marketing_purposes,id',
            'unit_type_id' => 'nullable|exists:unit_types,id',
            'full_description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:20480',
            'status' => 'nullable|string|in:pending,approved,disapproved,sold out,under offer,draft',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'investment_type' => 'nullable|string',
            'financing_type' => 'nullable|string',
            'is_cash_buy' => 'nullable|boolean',
            'exchange_deadline' => 'nullable|string',
            'completion_deadline' => 'nullable|string',
            'assignable_contract' => 'nullable|string',
            'tenure_type' => 'nullable|string',
            'share_of_freehold' => 'nullable|string',
            'lease_years_remaining' => 'nullable|integer',
            'monthly_rent' => 'nullable|numeric',
            'yearly_rent' => 'nullable|numeric',
            'is_currently_rented' => 'nullable|boolean',
        ]);

        $data = $request->except(['thumbnail', 'gallery_images', 'features', 'video', 'costs', 'tenants']);

        // Platform Fee Calculation (Flat 2%)
        if (isset($data['price'])) {
            $vendorPrice = (float) $data['price'];
            $psgFee = $vendorPrice * 0.02;
            $data['psg_fees'] = $psgFee;
            $data['portal_sale_price'] = $vendorPrice + $psgFee;
        }

        $data['discount_available'] = $request->has('discount_available');
        $data['is_currently_rented'] = $request->has('is_currently_rented');
        $data['is_cash_buy'] = (bool) $request->is_cash_buy;

        if ($request->has('status')) {
            if (auth()->user()->role === 'admin') {
                $data['status'] = $request->status;
            } else {
                if (in_array($request->status, ['pending', 'draft', 'sold out'])) {
                    $data['status'] = $request->status;
                }
            }
        }

        if ($request->hasFile('thumbnail')) {
            if ($property->thumbnail) {
                Storage::disk('public')->delete($property->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('properties/thumbnails', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $images = [];
            foreach ($request->file('gallery_images') as $image) {
                $images[] = $image->store('properties/gallery', 'public');
            }
            $data['gallery_images'] = $images;
        }

        if ($request->hasFile('video')) {
            if ($property->video_url) {
                Storage::disk('public')->delete($property->video_url);
            }
            $data['video_url'] = $request->file('video')->store('properties/videos', 'public');
        }

        $property->update($data);

        // Sync features
        if ($request->has('features')) {
            $property->features()->sync($request->features);
        } else {
            $property->features()->detach();
        }

        // Sync Costs
        $property->costs()->delete();
        if ($request->has('costs')) {
            foreach ($request->costs as $cost) {
                if (!empty($cost['name']) && !empty($cost['amount'])) {
                    $property->costs()->create([
                        'name' => $cost['name'],
                        'amount' => $cost['amount'],
                    ]);
                }
            }
        }

        // Sync Tenants
        $property->tenants()->delete();
        if ($request->has('tenants')) {
            foreach ($request->tenants as $tenant) {
                if (!empty($tenant['name'])) {
                    $property->tenants()->create([
                        'name' => $tenant['name'],
                        'phone' => $tenant['phone'] ?? null,
                        'email' => $tenant['email'] ?? null,
                        'is_primary' => isset($tenant['is_primary']),
                    ]);
                }
            }
        }

        $matchingService->findMatchesForProperty($property);

        return redirect()->route('admin.available-properties.index')->with('success', 'Property updated successfully');
    }

    public function destroy($id)
    {
        $property = AvailableProperty::findOrFail($id);
        if ($property->thumbnail)
            Storage::disk('public')->delete($property->thumbnail);
        if ($property->gallery_images) {
            foreach ($property->gallery_images as $image)
                Storage::disk('public')->delete($image);
        }
        if ($property->video_url)
            Storage::disk('public')->delete($property->video_url);
        $property->features()->detach();
        $property->delete();

        return redirect()->route('admin.available-properties.index')->with('success', 'Property deleted successfully');
    }

    public function downloadBrochure($id)
    {
        ini_set('memory_limit', '256M');
        try {
            $property = AvailableProperty::with(['propertyType', 'marketingPurpose', 'unitType', 'features', 'costs'])->findOrFail($id);
            $user = auth()->user();
            $filename = 'Brochure_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $property->headline) . '.pdf';

            // Fetch Map as Base64
            $mapBase64 = null;
            if ($property->latitude && $property->longitude) {
                try {
                    $apiKey = 'AIzaSyDtagAWzRL7h2Safzk7EwKK0x6v42RlsdI';
                    $mapUrl = "https://maps.googleapis.com/maps/api/staticmap?center={$property->latitude},{$property->longitude}&zoom=15&size=600x300&maptype=roadmap&markers=color:red%7C{$property->latitude},{$property->longitude}&key={$apiKey}";
                    $mapData = @file_get_contents($mapUrl);
                    if ($mapData) {
                        $mapBase64 = 'data:image/png;base64,' . base64_encode($mapData);
                    }
                } catch (\Exception $e) {
                    \Log::warning('Brochure Map Fetch failed: ' . $e->getMessage());
                }
            }

            // Fetch Property Thumbnail as Base64
            $thumbnailBase64 = null;
            if ($property->thumbnail && Storage::disk('public')->exists($property->thumbnail)) {
                $thumbData = Storage::disk('public')->get($property->thumbnail);
                $thumbnailBase64 = 'data:image/jpeg;base64,' . base64_encode($thumbData);
            }

            // Fetch Gallery Images as Base64
            $galleryBase64 = [];
            if ($property->gallery_images) {
                foreach ($property->gallery_images as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        $imgData = Storage::disk('public')->get($image);
                        $galleryBase64[] = 'data:image/jpeg;base64,' . base64_encode($imgData);
                    }
                }
            }

            // Fetch Logo as Base64
            $logoBase64 = null;
            if (file_exists(public_path('logo.png'))) {
                $logoData = file_get_contents(public_path('logo.png'));
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }

            $pdf = Pdf::setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ])->loadView('available_properties.brochure', compact('property', 'user', 'mapBase64', 'thumbnailBase64', 'galleryBase64', 'logoBase64'));

            return $pdf->download($filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Could not generate brochure: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $property = AvailableProperty::findOrFail($id);
        return view('available_properties.show', compact('property'));
    }

    public function updateStatus(Request $request, $id)
    {
        $property = AvailableProperty::findOrFail($id);

        $allowedStatuses = 'pending,approved,disapproved,sold out,under offer,draft';
        $request->validate(['status' => 'required|in:' . $allowedStatuses]);

        if (auth()->user()->role === 'admin') {
            $property->status = $request->status;
        } else {
            if (in_array($request->status, ['pending', 'sold out', 'under offer', 'draft'])) {
                $property->status = $request->status;
            } else {
                return back()->with('error', 'Unauthorized status transition.');
            }
        }

        $property->save();
        return back()->with('success', 'Status updated successfully');
    }

    public function notifyAgents(Request $request, $id)
    {
        $property = AvailableProperty::findOrFail($id);
        $sender = auth()->user();
        $query = \App\Models\User::where('role', 'agent')->where('id', '!=', $sender->id);
        if ($request->has('agent_ids'))
            $query->whereIn('id', $request->agent_ids);
        $agents = $query->get();
        foreach ($agents as $agent) {
            if ($agent->email) {
                \Illuminate\Support\Facades\Mail::to($agent->email)->send(new \App\Mail\AgentPropertyNotificationMail($property, $sender));
            }
        }
        return back()->with('success', 'Notifications sent.');
    }

    public function sendBulkEmail(Request $request)
    {
        $request->validate(['property_ids' => 'required|array']);

        $properties = AvailableProperty::whereIn('id', $request->property_ids)->get();
        $sender = auth()->user();
        $recipients = collect();

        // 1. Add all agents if selected
        if ($request->send_to_all_agents) {
            $recipients = $recipients->merge(\App\Models\User::where('role', 'agent')->pluck('email'));
        }

        // 2. Add specific agents if selected
        if ($request->agent_ids && is_array($request->agent_ids)) {
            $recipients = $recipients->merge(\App\Models\User::whereIn('id', $request->agent_ids)->pluck('email'));
        }

        // 3. Add custom emails (comma separated)
        if ($request->custom_emails) {
            $customEmails = array_map('trim', explode(',', $request->custom_emails));
            foreach ($customEmails as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $recipients->push($email);
                }
            }
        }

        $recipients = $recipients->unique()->filter();

        if ($recipients->isEmpty()) {
            \Log::warning("Bulk email attempt with no recipients: properties " . implode(',', $request->property_ids));
            return response()->json(['success' => false, 'message' => 'No valid recipients selected.']);
        }

        \Log::info("Sending bulk email to: " . $recipients->implode(', '));

        foreach ($recipients as $recipient) {
            try {
                \Illuminate\Support\Facades\Mail::to($recipient)->send(new \App\Mail\BulkPropertyMail($properties, $sender, $request->message ?? ''));
            } catch (\Exception $e) {
                \Log::error("Failed to send bulk email to $recipient: " . $e->getMessage());
            }
        }

        return response()->json(['success' => true, 'message' => 'Emails sent successfully to ' . $recipients->count() . ' recipients.']);
    }
}
