<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category', 'description', 'short_description',
        'price_start', 'price_end', 'price_jasa', 'estimated_days', 'image',
        'is_active', 'is_featured', 'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price_start' => 'decimal:0',
        'price_end' => 'decimal:0',
        'price_jasa' => 'decimal:0',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'laptop' => 'Laptop',
            'printer' => 'Printer',
            'pc' => 'PC / Komputer',
            'software' => 'Installasi Software',
            default => ucfirst($this->category),
        };
    }

    public function getPriceRangeAttribute()
    {
        if ($this->price_end) {
            return 'Rp ' . number_format($this->price_start, 0, ',', '.') . ' - Rp ' . number_format($this->price_end, 0, ',', '.');
        }
        return 'Mulai Rp ' . number_format($this->price_start, 0, ',', '.');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($service) {
            if (!$service->slug) {
                $service->slug = Str::slug($service->name);
            }
        });
    }
}
