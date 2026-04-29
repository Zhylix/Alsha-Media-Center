<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTicket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_code',
        'customer_name',
        'phone',
        'device_type',
        'problem',
        'status',
    ];

    protected $casts = [
        'device_type' => 'string',
        'status' => 'string',
    ];

    public static array $statuses = [
        'pending'      => 'Menunggu Pengecekan',
        'checking'     => 'Sedang Dicek Teknisi',
        'proses'       => 'Sedang Diperbaiki',
        'waiting_part' => 'Menunggu Sparepart',
        'selesai'      => 'Sudah Selesai',
        'diambil'      => 'Sudah Diambil',
    ];

    public static array $statusColors = [
        'pending'      => 'yellow',
        'checking'     => 'orange',
        'proses'       => 'blue',
        'waiting_part' => 'purple',
        'selesai'      => 'green',
        'diambil'      => 'gray',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->service_code)) {
                $ticket->service_code = self::generateServiceCode();
            }
        });
    }

    public static function generateServiceCode(): string
    {
        $today = date('Ymd');
        $count = self::withTrashed()
            ->whereDate('created_at', today())
            ->count() + 1;

        return "AMC-{$today}-" . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::$statuses[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return self::$statusColors[$this->status] ?? 'gray';
    }

    public function getDeviceTypeLabelAttribute(): string
    {
        return match ($this->device_type) {
            'pc'      => 'PC / Komputer',
            'laptop'  => 'Laptop',
            'printer' => 'Printer',
            default   => ucfirst($this->device_type),
        };
    }

    public function getProgressPercentAttribute(): int
    {
        $steps = array_keys(self::$statuses);
        $index = array_search($this->status, $steps);

        if ($index === false) {
            return 0;
        }

        $total = count($steps);
        return (int) round((($index + 1) / $total) * 100);
    }

    public function getProgressStepAttribute(): string
    {
        $steps = array_keys(self::$statuses);
        $index = array_search($this->status, $steps);

        if ($index === false) {
            return '0/' . count($steps);
        }

        return ($index + 1) . '/' . count($steps);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('service_code', 'like', "%{$term}%")
              ->orWhere('customer_name', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%");
        });
    }
}

