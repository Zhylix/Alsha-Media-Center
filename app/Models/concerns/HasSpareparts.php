<?php

namespace App\Models\concerns;

use App\Models\Sparepart;

trait HasSpareparts
{
    public function spareparts()
    {
        return $this->belongsToMany(Sparepart::class, 'service_sparepart', 'service_id', 'sparepart_id');
    }
}

