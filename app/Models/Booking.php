<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'service_id',
        'event_date',
        'event_time',
        'event_location',
        'event_type',
        'notes',
        'status',
        'total_price',
        'payment_status',
        'payment_method',
        'payment_proof'
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'total_price' => 'integer'
        ];
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}