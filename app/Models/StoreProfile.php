<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProfile extends Model
{
    protected $fillable = [
        'store_name', 'tagline', 'description', 'address', 'city',
        'phone', 'whatsapp', 'email', 'instagram', 'facebook', 'youtube',
        'latitude', 'longitude', 'google_maps_link', 'google_maps_direct_link', 'open_hours', 'open_days', 'logo', 'hero_image'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
