<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserCompletedProperty;
use App\Models\AvailableProperty;
use App\Models\PropertyOffer;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'phone',
        'phone_number',
        'address',
        'address_line1',
        'address_line2',
        'city',
        'postcode',
        'country',
        'company_name',
        'company_registration',
        'about_me',
        'investment_credits',
        'investment_type',
        'budget',
        'min_budget',
        'max_budget',
        'property_interests',
        'latitude',
        'longitude',
        'is_cash_buy',
        'status',
        'is_active',
    ];

    public function completedProperties()
    {
        return $this->hasMany(UserCompletedProperty::class);
    }

    public function properties()
    {
        return $this->hasMany(AvailableProperty::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(PropertyFavorite::class);
    }

    public function offers()
    {
        return $this->hasMany(PropertyOffer::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
