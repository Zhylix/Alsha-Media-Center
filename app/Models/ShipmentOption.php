<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentOption extends Model
{
    protected $fillable = ['name', 'provider', 'description', 'price', 'estimated_days', 'logo', 'is_active'];
    protected $casts = ['is_active' => 'boolean', 'price' => 'decimal:0'];

    public function getPriceDisplayAttribute()
    {
        return $this->price == 0 ? 'Gratis' : 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
