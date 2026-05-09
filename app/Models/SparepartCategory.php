<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SparepartCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category',
        'part_type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function spareparts()
    {
        return $this->hasMany(Sparepart::class);
    }

    public function getServiceCategoryLabelAttribute(): string
    {
        return match ($this->service_category) {
            'pc' => 'PC / Komputer',
            'laptop' => 'Laptop',
            'printer' => 'Printer',
            'software' => 'Installasi Software',
            default => ucfirst($this->service_category),
        };
    }
}

