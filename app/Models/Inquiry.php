<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'property_id',
        'owner_id',
        'name',
        'email',
        'phone',
        'ready_to_buy',
        'investment_type',
        'is_cash_buyer',
        'budget',
        'experience_level',
        'comments',
        'source_page',
        'is_read',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function property()
    {
        return $this->belongsTo(AvailableProperty::class, 'property_id');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
