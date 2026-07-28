<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'adventure_id',
        'booking_date',
        'participants',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adventure()
    {
        return $this->belongsTo(Adventure::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
