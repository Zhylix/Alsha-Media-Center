<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['customer_name', 'customer_avatar', 'service_type', 'rating', 'comment', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
