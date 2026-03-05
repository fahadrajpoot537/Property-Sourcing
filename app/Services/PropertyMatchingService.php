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
        // 1. Check CRM Investors
        $crmInvestors = Investor::with('agent')->get();
        foreach ($crmInvestors as $investor) {
            if ($investor instanceof Investor && $this->isMatch($investor, $property)) {
                $this->notifyAgent($investor, $property);
            }
        }

        // 2. Check Public Users (Investors)
        $publicUsers = \App\Models\User::where('role', 'user')->get();
        foreach ($publicUsers as $user) {
            if ($this->isMatch($user, $property)) {
                $this->notifyPublicUser($user, $property);
            }
        }
    }

    /**
     * Check all properties for matches when a new investor/user is added.
     */
    public function findMatchesForInvestor($investorOrUser)
    {
        $properties = AvailableProperty::where('status', 'approved')->get();

        foreach ($properties as $property) {
            if ($this->isMatch($investorOrUser, $property)) {
                if ($investorOrUser instanceof Investor) {
                    $this->notifyAgent($investorOrUser, $property);
                } else {
                    $this->notifyPublicUser($investorOrUser, $property);
                }
            }
        }
    }

    /**
     * Matching heuristic.
     */
    private function isMatch($investor, AvailableProperty $property)
    {
        $isUser = $investor instanceof \App\Models\User;

        // 1. Location match
        $locationMatch = false;
        $investorLocation = $isUser ? $investor->address : $investor->location;
        $investorLat = $investor->latitude;
        $investorLng = $investor->longitude;
        $areasOfInterest = $isUser ? ($investor->areas_of_interest ?? []) : ($investor->areas_of_interest ?? []);

        if (!empty($areasOfInterest) && !in_array('All', $areasOfInterest)) {
            foreach ($areasOfInterest as $area) {
                if (
                    Str::contains(strtolower($property->location), strtolower($area)) ||
                    Str::contains(strtolower($property->postcode), strtolower($area))
                ) {
                    $locationMatch = true;
                    break;
                }
            }
        } elseif ($investorLocation && $property->location) {
            if (
                Str::contains(strtolower($property->location), strtolower($investorLocation)) ||
                Str::contains(strtolower($investorLocation), strtolower($property->location)) ||
                Str::contains(strtolower($property->postcode), strtolower($investorLocation))
            ) {
                $locationMatch = true;
            }
            if (!$locationMatch && $investorLat && $investorLng && $property->latitude && $property->longitude) {
                $distance = $this->calculateDistance($investorLat, $investorLng, $property->latitude, $property->longitude);
                if ($distance <= 25)
                    $locationMatch = true;
            }
        } else {
            $locationMatch = true;
        }

        if (!$locationMatch)
            return false;

        // 2. Budget match
        $propertyTotalPrice = (float) $property->price + (float) ($property->psg_fees ?? 0);

        $minBudget = !empty($investor->min_budget) ? (float) $investor->min_budget : null;
        $maxBudget = !empty($investor->max_budget) ? (float) $investor->max_budget : null;

        // If both are present, ensure min <= max for the check
        if ($minBudget !== null && $maxBudget !== null && $minBudget > $maxBudget) {
            $temp = $minBudget;
            $minBudget = $maxBudget;
            $maxBudget = $temp;
        }

        if ($minBudget !== null && $propertyTotalPrice < $minBudget) {
            return false;
        }
        if ($maxBudget !== null && $propertyTotalPrice > $maxBudget) {
            return false;
        }

        // If min/max budget not set but legacy budget is
        if ($minBudget === null && $maxBudget === null) {
            $investorBudget = (float) preg_replace('/[^0-9.]/', '', $investor->budget);
            if ($investorBudget > 0 && $propertyTotalPrice > $investorBudget * 1.1) {
                return false;
            }
        }

        // 3. Cash Buyer match
        if ($property->is_cash_buy && !$investor->is_cash_buy) {
            return false;
        }

        // 4. Deals of interest (Strategy match)
        $dealsOfInterest = $isUser ? ($investor->property_interests ? explode(', ', $investor->property_interests) : []) : ($investor->deals_of_interest ?? []);

        if (!empty($dealsOfInterest) && !in_array('All', $dealsOfInterest) && $property->investment_type) {
            $strategyFound = false;
            $propType = strtolower($property->investment_type);

            // Mapping for CRM Investor strategies to Property investment types
            $strategyMap = [
                'BMV' => ['bmv', 'bmv_deal'],
                'Refurbishment' => ['refurb', 'refurb_deal'],
                'Rental' => ['rental'],
                'HMO' => ['hmo'],
                'Development' => ['buy_to_sell', 'development'],
                'Other' => ['other'],
            ];

            foreach ($dealsOfInterest as $deal) {
                $dealLower = strtolower($deal);

                // Direct match check
                if (Str::contains($propType, $dealLower) || Str::contains($dealLower, $propType)) {
                    $strategyFound = true;
                    break;
                }

                // Map check
                if (isset($strategyMap[$deal])) {
                    foreach ($strategyMap[$deal] as $mapKey) {
                        if (Str::contains($propType, $mapKey)) {
                            $strategyFound = true;
                            break 2;
                        }
                    }
                }
            }
            if (!$strategyFound)
                return false;
        }

        // 5. Property Types match
        $propertyTypes = $isUser ? ($investor->property_interests ? explode(', ', $investor->property_interests) : []) : ($investor->property_types ?? []);
        if (!empty($propertyTypes) && !in_array('Any', $propertyTypes)) {
            $propertyTypeMatch = false;
            $catName = $property->propertyType ? strtolower($property->propertyType->name) : '';
            $unitName = $property->unitType ? strtolower($property->unitType->name) : '';

            foreach ($propertyTypes as $type) {
                $typeLower = strtolower($type);
                if (
                    ($catName && Str::contains($catName, $typeLower)) ||
                    ($unitName && Str::contains($unitName, $typeLower)) ||
                    ($catName && Str::contains($typeLower, $catName)) ||
                    ($unitName && Str::contains($typeLower, $unitName))
                ) {
                    $propertyTypeMatch = true;
                    break;
                }
            }
            if (!$propertyTypeMatch)
                return false;
        }

        // 6. Bedrooms
        if ($investor->min_bedrooms && $property->bedrooms < $investor->min_bedrooms)
            return false;
        if ($investor->max_bedrooms && $property->bedrooms > $investor->max_bedrooms)
            return false;

        // 7. Bathrooms
        if ($investor->min_bathrooms && $property->bathrooms < $investor->min_bathrooms)
            return false;
        if ($investor->max_bathrooms && $property->bathrooms > $investor->max_bathrooms)
            return false;

        return true;
    }

    private function notifyAgent(Investor $investor, AvailableProperty $property)
    {
        if ($investor->agent && $investor->agent->email) {
            Mail::to($investor->agent->email)->send(new AgentMatchedPropertyMail($investor->agent, $investor, $property));
        }
    }

    private function notifyPublicUser(\App\Models\User $user, AvailableProperty $property)
    {
        if ($user->email) {
            \Log::info("Match found for public user $user->email with property $property->headline");
            try {
                Mail::to($user->email)->send(new \App\Mail\BulkPropertyMail($property, \App\Models\User::where('role', 'admin')->first(), 'Great news! A new property that matches your investment criteria has just been listed.'));
            } catch (\Exception $e) {
                \Log::error("Public user notification failed: " . $e->getMessage());
            }
        }
    }

    /**
     * Get all matching properties for a given investor.
     */
    public function getMatchesForInvestor($investorOrUser, $agentId = null)
    {
        $query = AvailableProperty::with(['propertyType', 'unitType'])
            ->whereIn('status', ['approved', 'under offer']);

        // If agentId is provided (non-admin), only show properties added by that agent
        if ($agentId) {
            $query->where('user_id', $agentId);
        }

        $properties = $query->latest()->get();

        $matches = [];
        foreach ($properties as $property) {
            if ($this->isMatch($investorOrUser, $property)) {
                $matches[] = $property;
            }
        }

        return collect($matches);
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
