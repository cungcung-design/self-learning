<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Booking extends Model
{
    use Notifiable;

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
