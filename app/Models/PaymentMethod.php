<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'type', 'provider', 'account_number', 'account_name', 'instructions', 'logo', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'bank_transfer' => 'Transfer Bank',
            'e_wallet'      => 'E-Wallet',
            'cod'           => 'Bayar di Tempat (COD)',
            default         => ucfirst($this->type),
        };
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
