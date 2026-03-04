<?php

namespace App\Observers;

use App\Models\AvailableProperty;
use App\Models\Inquiry;
use App\Mail\SimilarPropertyNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AvailablePropertyObserver
{
    public function created(AvailableProperty $availableProperty): void
    {
        // 2. Notify Matching Investors
        if ($availableProperty->status === 'approved') {
            $this->notifyMatchingInvestors($availableProperty);
        }
    }

    /**
     * Handle the AvailableProperty "updated" event.
     */
    public function updated(AvailableProperty $availableProperty): void
    {
        // If status changed to approved, notify investors
        if ($availableProperty->wasChanged('status') && $availableProperty->status === 'approved') {
            $this->notifyMatchingInvestors($availableProperty);
        }
    }

    /**
     * Notify matching investors based on their previous inquiries.
     */
    protected function notifyMatchingInvestors(AvailableProperty $property): void
    {
        // 1. Get inquiries from last 3 months with related property data
        $recentInquiries = Inquiry::with('property')
            ->where('type', 'property')
            ->where('property_id', '!=', null)
            ->where('created_at', '>=', now()->subMonths(3))
            ->get();

        $notifiedEmails = [];

        foreach ($recentInquiries as $inquiry) {
            $originalProperty = $inquiry->property;

            if (!$originalProperty || in_array($inquiry->email, $notifiedEmails)) {
                continue;
            }

            // Criteria Matching:

            // A. Location Match (Check if area code like E14 is in the location string)
            // Extract potential area code from new property location (naive check)
            $matchesLocation = false;
            $newLocation = strtoupper($property->location);
            $oldLocation = strtoupper($originalProperty->location);

            // Extract the first part of the postcode if possible (e.g. E14)
            // or just check if keywords exist in both
            // For now, let's check if they share a common word of length 3+ that looks like a postcode (e.g. E14, SE1, etc.)
            $newWords = preg_split('/[\s,]+/', $newLocation);
            $oldWords = preg_split('/[\s,]+/', $oldLocation);

            foreach ($newWords as $word) {
                if (strlen($word) >= 2 && in_array($word, $oldWords)) {
                    $matchesLocation = true;
                    break;
                }
            }

            // B. Bed & Bath configuration
            $matchesConfig = ($property->bedrooms == $originalProperty->bedrooms) &&
                ($property->bathrooms == $originalProperty->bathrooms);

            // C. Property & Unit Type configuration
            $matchesType = ($property->property_type_id == $originalProperty->property_type_id) &&
                ($property->unit_type_id == $originalProperty->unit_type_id);

            // D. Price Match (+/- 20%)
            $minPrice = $originalProperty->price * 0.8;
            $maxPrice = $originalProperty->price * 1.2;
            $matchesPrice = ($property->price >= $minPrice && $property->price <= $maxPrice);

            // If all criteria match, send email
            if ($matchesLocation && $matchesConfig && $matchesType && $matchesPrice) {
                try {
                    Mail::to($inquiry->email)->send(new SimilarPropertyNotification($property));
                    $notifiedEmails[] = $inquiry->email;
                    Log::info("Sent similar property notification to {$inquiry->email} for property #{$property->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to send notification to {$inquiry->email}: " . $e->getMessage());
                }
            }
        }
    }
}
