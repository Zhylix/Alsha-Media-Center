<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'image', 'discount_info',
        'price',
        'is_active',
        'sort_order',
        // legacy fields (masih ada di DB)
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'price' => 'decimal:0',
    ];

    // Paket bersifat permanen selama is_active = true
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getIsValidAttribute()
    {
        return (bool) $this->is_active;
    }
}

