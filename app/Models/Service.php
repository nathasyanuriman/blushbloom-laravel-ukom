<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_active' => 'boolean'
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}