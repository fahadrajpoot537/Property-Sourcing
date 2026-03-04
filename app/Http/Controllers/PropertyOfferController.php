<?php

namespace App\Http\Controllers;

use App\Models\PropertyOffer;
use App\Models\AvailableProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PropertyOfferController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:available_properties,id',
            'offer_amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        $property = AvailableProperty::findOrFail($request->property_id);

        // Check if user has already made an offer on this property (optional, but good practice)
        // For now, allow multiple offers.

        $offer = PropertyOffer::create([
            'available_property_id' => $property->id,
            'user_id' => Auth::id(),
            'offer_amount' => $request->offer_amount,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Send email notification to admin
        $this->sendOfferNotification($offer, $property);

        return back()->with('success', 'Your offer has been submitted successfully!');
    }

    private function sendOfferNotification($offer, $property)
    {
        $adminEmail = 'webleads@propertysourcinggroup.co.uk';
        $user = Auth::user();

        $data = [
            'user_name' => $user->name,
            'user_email' => $user->email,
            'property_title' => $property->headline,
            'property_location' => $property->location,
            'offer_amount' => $offer->offer_amount,
            'notes' => $offer->notes,
            'offer_url' => route('admin.property-offers.index', $property->id),
        ];

        try {
            Mail::send('emails.property_offer', $data, function ($message) use ($adminEmail, $property, $user) {
                $message->to($adminEmail)
                    ->subject('New Property Offer: ' . $property->headline . ' from ' . $user->name);
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send offer notification email: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of the resource for the logged-in user.
     */
    public function index()
    {
        $offers = PropertyOffer::with('property')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.offers.index', compact('offers'));
    }
}
