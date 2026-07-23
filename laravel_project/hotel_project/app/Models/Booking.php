<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'room_id',
        'name',
        'email',
        'phone',
        'start_date',
        'end_date',
        'status',
    ];
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
