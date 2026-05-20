<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceSparepart extends Model
{
    use HasFactory;

    protected $table = 'service_sparepart';

    protected $fillable = [
        'service_id',
        'sparepart_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id');
    }
}

