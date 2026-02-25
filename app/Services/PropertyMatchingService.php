<?php

namespace App\Services;

use App\Models\AvailableProperty;
use App\Models\Investor;
use App\Mail\AgentMatchedPropertyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PropertyMatchingService
{
    /**
     * Check all investors for matches when a new property is added.
     */
    public function findMatchesForProperty(AvailableProperty $property)
    {
        $investors = Investor::with('agent')->get();

        foreach ($investors as $investor) {
            if ($this->isMatch($investor, $property)) {
                $this->notifyAgent($investor, $property);
            }
        }
    }

    /**
     * Check all properties for matches when a new investor is added.
     */
    public function findMatchesForInvestor(Investor $investor)
    {
        $properties = AvailableProperty::where('is_active', true)->get();

        foreach ($properties as $property) {
            if ($this->isMatch($investor, $property)) {
                $this->notifyAgent($investor, $property);
            }
        }
    }

    /**
     * Matching heuristic.
     */
    private function isMatch(Investor $investor, AvailableProperty $property)
    {
        // 1. Location match (simple string contains or proximity if lat/lng exists)
        $locationMatch = false;
        if ($investor->location && $property->location) {
            if (
                Str::contains(strtolower($property->location), strtolower($investor->location)) ||
                Str::contains(strtolower($investor->location), strtolower($property->location))
            ) {
                $locationMatch = true;
            }

            // Proximity check if both have coordinates (within 10km)
            if (!$locationMatch && $investor->latitude && $investor->longitude && $property->latitude && $property->longitude) {
                $distance = $this->calculateDistance(
                    $investor->latitude,
                    $investor->longitude,
                    $property->latitude,
                    $property->longitude
                );
                if ($distance <= 10) { // 10km radius
                    $locationMatch = true;
                }
            }
        } else {
            // If investor hasn't specified location, we might assume it matches anyway or skip.
            // For now, let's assume they MUST have a location or we skip.
        }

        if (!$locationMatch)
            return false;

        // 2. Budget match
        // Budget is stored as string like "£100,000 - £200,000" or just "200000"
        // We try to extract digits.
        $investorBudget = (float) preg_replace('/[^0-9.]/', '', $investor->budget);
        if ($investorBudget > 0 && $property->price > $investorBudget * 1.2) { // Allow 20% over budget
            return false;
        }

        // 3. Investment Interest match
        if ($investor->investment_interest && $property->investment_type) {
            if (
                !Str::contains(strtolower($investor->investment_interest), strtolower($property->investment_type)) &&
                !Str::contains(strtolower($property->investment_type), strtolower($investor->investment_interest))
            ) {
                // If they don't explicitly match, check if property type is in property_interests array/string
                if ($investor->property_interests) {
                    if (!Str::contains(strtolower($investor->property_interests), strtolower($property->investment_type))) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    private function notifyAgent(Investor $investor, AvailableProperty $property)
    {
        if ($investor->agent && $investor->agent->email) {
            Mail::to($investor->agent->email)->send(new AgentMatchedPropertyMail($investor->agent, $investor, $property));
        }
    }

    /**
     * Calculate distance between two points in km (Haversine formula).
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}
