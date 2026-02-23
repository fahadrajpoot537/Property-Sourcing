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
        $query = AvailableProperty::where('is_active', true)->where('status', 'approved');

        // Price Filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Beds & Baths
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        // Property Type
        if ($request->filled('property_type')) {
            $query->where('property_type_id', $request->property_type);
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

        $properties = $query->with(['propertyType', 'marketingPurpose'])->latest()->paginate(12)->withQueryString();
        $propertyTypes = \App\Models\PropertyType::all();

        return view('available_properties.index', compact('properties', 'propertyTypes'));
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

    public function adminIndex()
    {
        $query = AvailableProperty::with(['propertyType', 'marketingPurpose', 'owner'])
            ->where('user_id', auth()->id())
            ->latest();

        $properties = $query->paginate(10);
        return view('admin.available_properties.index', compact('properties'));
    }

    public function create()
    {
        $propertyTypes = \App\Models\PropertyType::all();
        $marketingPurposes = \App\Models\MarketingPurpose::all();
        $unitTypes = \App\Models\UnitType::all();
        $features = \App\Models\Feature::all();

        return view('available_properties.create', compact('propertyTypes', 'marketingPurposes', 'unitTypes', 'features'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'headline' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'property_type_id' => 'required|exists:property_types,id',
            'marketing_purpose_id' => 'required|exists:marketing_purposes,id',
            'unit_type_id' => 'nullable|exists:unit_types,id',
            'full_description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:20480',
            'status' => 'nullable|string|in:pending,approved,disapproved,sold out',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            // New Fields Validation
            'current_value' => 'nullable|numeric',
            'purchase_date' => 'nullable|date',
            'financing_type' => 'nullable|in:cash,mortgage',
            'loan_amount' => 'nullable|numeric',
            'interest_rate' => 'nullable|numeric',
            'lender_name' => 'nullable|string',
            'monthly_payment' => 'nullable|numeric', // Mortgage monthly payment override
            'investment_type' => 'nullable|in:buy_to_sell,rental,bmv_deal,refurb_deal,hmo,btl,brr,r2r,serviced_accommodation',
            'sale_price' => 'nullable|numeric',
            'sale_date' => 'nullable|date',
            'monthly_rent' => 'nullable|numeric', // Rental income
            'is_currently_rented' => 'nullable|boolean',
            'tenure_type' => 'nullable|in:freehold,leasehold',
            'service_charge' => 'nullable|numeric',
            'ground_rent' => 'nullable|numeric',
            'lease_years_remaining' => 'nullable|integer',
            'gas_safety_issue_date' => 'nullable|date',
            'gas_safety_expiry_date' => 'nullable|date',
            'electrical_issue_date' => 'nullable|date',
            'electrical_expiry_date' => 'nullable|date',
            // Associated Costs (Array)
            'costs' => 'nullable|array',
            'costs.*.name' => 'required_with:costs|string',
            'costs.*.amount' => 'required_with:costs|numeric',
            // Tenants (Array)
            'tenants' => 'nullable|array',
            'tenants.*.name' => 'required_with:tenants|string',
            'tenants.*.phone' => 'nullable|string',
            'tenants.*.email' => 'nullable|email',
            'tenants.*.is_primary' => 'nullable|boolean',
        ]);

        $data = $request->except(['thumbnail', 'gallery_images', 'features', 'video', 'costs', 'tenants']);
        $data['discount_available'] = $request->has('discount_available');
        $data['is_currently_rented'] = $request->has('is_currently_rented');

        // Status Security
        if (auth()->user()->role === 'admin') {
            $data['status'] = $request->status ?? 'pending';
        } else {
            if ($request->has('status') && in_array($request->status, ['pending', 'sold out'])) {
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

    public function update(Request $request, $id)
    {
        $property = AvailableProperty::findOrFail($id);

        $request->validate([
            'headline' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'property_type_id' => 'required|exists:property_types,id',
            'marketing_purpose_id' => 'required|exists:marketing_purposes,id',
            'unit_type_id' => 'nullable|exists:unit_types,id',
            'full_description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:20480', // 20MB max
            'status' => 'nullable|string|in:pending,approved,disapproved,sold out',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            // New Fields Validation
            'current_value' => 'nullable|numeric',
            'purchase_date' => 'nullable|date',
            'financing_type' => 'nullable|in:cash,mortgage',
            'loan_amount' => 'nullable|numeric',
            'interest_rate' => 'nullable|numeric',
            'lender_name' => 'nullable|string',
            'monthly_payment' => 'nullable|numeric',
            'investment_type' => 'nullable|in:buy_to_sell,rental,bmv_deal,refurb_deal,hmo,btl,brr,r2r,serviced_accommodation',
            'sale_price' => 'nullable|numeric',
            'sale_date' => 'nullable|date',
            'monthly_rent' => 'nullable|numeric',
            'is_currently_rented' => 'nullable|boolean',
            'tenure_type' => 'nullable|in:freehold,leasehold',
            'service_charge' => 'nullable|numeric',
            'ground_rent' => 'nullable|numeric',
            'lease_years_remaining' => 'nullable|integer',
            'gas_safety_issue_date' => 'nullable|date',
            'gas_safety_expiry_date' => 'nullable|date',
            'electrical_issue_date' => 'nullable|date',
            'electrical_expiry_date' => 'nullable|date',
            // Associated Costs (Array)
            'costs' => 'nullable|array',
            'costs.*.name' => 'required_with:costs|string',
            'costs.*.amount' => 'required_with:costs|numeric',
            // Tenants (Array)
            'tenants' => 'nullable|array',
            'tenants.*.name' => 'required_with:tenants|string',
            'tenants.*.phone' => 'nullable|string',
            'tenants.*.email' => 'nullable|email',
            'tenants.*.is_primary' => 'nullable|boolean',
        ]);

        $data = $request->except(['thumbnail', 'gallery_images', 'features', 'video', 'costs', 'tenants']);
        $data['discount_available'] = $request->has('discount_available');
        $data['is_currently_rented'] = $request->has('is_currently_rented');

        if ($request->has('status')) {
            if (auth()->user()->role === 'admin') {
                $data['status'] = $request->status;
            } else {
                // Agents can only set pending or sold out
                if (in_array($request->status, ['pending', 'sold out'])) {
                    $data['status'] = $request->status;
                }
            }
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
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
            // Delete old video if exists
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

        // Sync Costs (Delete all and re-create)
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

        // Sync Tenants (Delete all and re-create)
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

        return redirect()->route('admin.available-properties.index')->with('success', 'Property updated successfully');
    }

    public function destroy($id)
    {
        $property = AvailableProperty::findOrFail($id);

        // Delete images
        if ($property->thumbnail) {
            Storage::disk('public')->delete($property->thumbnail);
        }

        if ($property->gallery_images) {
            foreach ($property->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        if ($property->video_url) {
            Storage::disk('public')->delete($property->video_url);
        }

        // Features will be detached automatically if cascade is set or we do it manually
        $property->features()->detach();
        $property->delete();

        return redirect()->route('admin.available-properties.index')->with('success', 'Property deleted successfully');
    }

    public function downloadBrochure($id)
    {
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', '120');
        try {
            $property = AvailableProperty::with(['propertyType', 'marketingPurpose', 'unitType', 'features', 'costs'])->findOrFail($id);
            $user = auth()->user();

            // Sanitize filename
            $filename = 'Brochure_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $property->headline) . '.pdf';

            $pdf = Pdf::loadView('available_properties.brochure', compact('property', 'user'));
            $pdf->setPaper('a4', 'portrait');

            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Log::error('Brochure download error for ID ' . $id . ': ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
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

        $request->validate([
            'status' => 'required|in:pending,approved,disapproved,sold out'
        ]);

        if (auth()->user()->role === 'admin') {
            $property->status = $request->status;
        } else {
            // Agents can only set pending or sold out
            if (in_array($request->status, ['pending', 'sold out'])) {
                $property->status = $request->status;
            } else {
                return back()->with('error', 'You are not authorized to set this status.');
            }
        }

        $property->save();

        return back()->with('success', 'Property status updated successfully');
    }
    public function sendBulkEmail(Request $request)
    {
        $request->validate([
            'property_ids' => 'required|array',
            'property_ids.*' => 'exists:available_properties,id',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
        ]);

        $properties = AvailableProperty::whereIn('id', $request->property_ids)->get();

        try {
            \Illuminate\Support\Facades\Mail::to($request->email)->send(new \App\Mail\PropertyDealsMail($properties, $request->subject));
            return response()->json(['success' => true, 'message' => 'Email sent successfully to ' . $request->email]);
        } catch (\Exception $e) {
            \Log::error('Bulk Email Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }
}
