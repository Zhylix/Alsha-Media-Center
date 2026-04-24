<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_name', 'customer_email', 'customer_phone',
        'customer_address', 'service_id', 'shipment_option_id', 'payment_method_id',
        'device_description', 'problem_description', 'service_price', 'shipment_price',
        'total_price', 'status', 'payment_status', 'payment_proof', 'notes',
        'confirmed_at', 'completed_at'
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'service_price' => 'decimal:0',
        'shipment_price' => 'decimal:0',
        'total_price' => 'decimal:0',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function shipmentOption()
    {
        return $this->belongsTo(ShipmentOption::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending'     => ['label' => 'Menunggu', 'color' => 'yellow'],
            'confirmed'   => ['label' => 'Dikonfirmasi', 'color' => 'blue'],
            'in_progress' => ['label' => 'Diproses', 'color' => 'purple'],
            'completed'   => ['label' => 'Selesai', 'color' => 'green'],
            'cancelled'   => ['label' => 'Dibatalkan', 'color' => 'red'],
            default       => ['label' => ucfirst($this->status), 'color' => 'gray'],
        };
    }

    public function getPaymentBadgeAttribute()
    {
        return match($this->payment_status) {
            'unpaid'   => ['label' => 'Belum Dibayar', 'color' => 'red'],
            'paid'     => ['label' => 'Sudah Dibayar', 'color' => 'green'],
            'refunded' => ['label' => 'Refund', 'color' => 'gray'],
            default    => ['label' => ucfirst($this->payment_status), 'color' => 'gray'],
        };
    }
}
