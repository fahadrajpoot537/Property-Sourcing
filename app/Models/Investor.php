<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Added this use statement for Str::contains
use App\Models\AvailableProperty; // Added this use statement for AvailableProperty

class Investor extends Model
{
    protected $fillable = [
        'agent_id',
        'user_id',
        'name',
        'address',
        'email',
        'phone',
        'budget',
        'min_budget',
        'max_budget',
        'is_cash_buy',
        'location',
        'latitude',
        'longitude',
        'investment_interest',
        'property_interests',
        'deals_of_interest',
        'property_types',
        'min_bedrooms',
        'max_bedrooms',
        'min_bathrooms',
        'max_bathrooms',
        'areas_of_interest',
        'notes',
    ];

    protected $casts = [
        'is_cash_buy' => 'boolean',
        'deals_of_interest' => 'array',
        'property_types' => 'array',
        'areas_of_interest' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'min_bedrooms' => 'integer',
        'max_bedrooms' => 'integer',
        'min_bathrooms' => 'integer',
        'max_bathrooms' => 'integer',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
