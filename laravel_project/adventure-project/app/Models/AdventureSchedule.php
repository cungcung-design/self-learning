<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdventureSchedule extends Model
{
    protected $fillable = [
        'adventure_id',
        'trip_date',
        'start_time',
        'end_time',
        'capacity',
        'booked',
        'status',
    ];

    protected $casts = [
        'trip_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function adventure()
    {
        return $this->belongsTo(Adventure::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'schedule_id');
    }
}
