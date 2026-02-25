<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $fillable = [
        'agent_id',
        'user_id',
        'name',
        'email',
        'phone',
        'budget',
        'investment_interest',
        'location',
        'latitude',
        'longitude',
        'property_interests',
        'notes',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
