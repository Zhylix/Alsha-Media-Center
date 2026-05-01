<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'username', 'password', 'avatar', 'whatsapp', 'role', 'is_active'];

    protected $hidden = ['password'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Check if admin is superadmin
     */
    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * Check if admin is regular admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if admin is active
     */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    /**
     * Scope to get only superadmins
     */
    public function scopeSuperadmins(Builder $query): Builder
    {
        return $query->where('role', 'superadmin');
    }

    /**
     * Scope to get only regular admins
     */
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope to get only active admins
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the primary admin for notifications (first active superadmin or first active admin)
     */
    public static function getPrimaryAdmin(): ?Admin
    {
        return static::active()
            ->orderByRaw("CASE role WHEN 'superadmin' THEN 0 ELSE 1 END")
            ->first();
    }

    /**
     * Get all active superadmins
     */
    public static function getActiveSuperadmins(): \Illuminate\Database\Eloquent\Collection
    {
        return static::active()->superadmins()->get();
    }
}
