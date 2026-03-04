<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableProperty;
use App\Models\PropertyOffer;
use App\Models\UserCompletedProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyOfferController extends Controller
{
    /**
     * Display a listing of offers for a specific property.
     */
    public function index(AvailableProperty $property)
    {
        $offers = $property->offers()->with('user')->latest()->get();
        return view('admin.property_offers.index', compact('property', 'offers'));
    }

    /**
     * Display a listing of all offers across all properties.
     */
    public function all()
    {
        $offers = PropertyOffer::with(['user', 'property'])->latest()->get();
        return view('admin.property_offers.all', compact('offers'));
    }

    /**
     * Update the status of an offer.
     */
    public function update(Request $request, PropertyOffer $offer)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,withdrawn',
        ]);

        $offer->status = $request->status;
        $offer->save();

        if ($request->status == 'accepted') {
            // Optionally update property status to 'sold out' or 'reserved'
            // $offer->property->update(['status' => 'reserved']);
        }

        return back()->with('success', 'Offer status updated successfully.');
    }

    /**
     * Mark an offer as completed (Sale Completed).
     * This acts as the trigger for Investment Credits.
     */
    public function complete(Request $request, PropertyOffer $offer)
    {
        // 1. Ensure offer is accepted first (logic check, optional but good)
        if ($offer->status !== 'accepted') {
            return back()->with('error', 'Offer must be accepted before marking as completed.');
        }

        DB::transaction(function () use ($offer) {
            // 2. Mark property as Sold Out
            $offer->property->update(['status' => 'sold out']);

            // 3. Create UserCompletedProperty record
            UserCompletedProperty::create([
                'user_id' => $offer->user_id,
                'property_address' => $offer->property->location, // Or specific address field
                'status' => 'completed',
                'approved_at' => now(),
            ]);

            // 4. Award Investment Credits (Batch Logic: 5 completions = 3,000 credits)
            $completedCount = UserCompletedProperty::where('user_id', $offer->user_id)->count();

            if ($completedCount > 0 && $completedCount % 5 === 0) {
                $offer->user->increment('investment_credits', 3000);
            }

            // 5. Update offer status to completed (if enum allows, or keep as accepted)
            // For now, let's keep it as accepted, but we logged the completion.
        });

        return back()->with('success', 'Property sale completed! User has been awarded investment credits.');
    }
}
