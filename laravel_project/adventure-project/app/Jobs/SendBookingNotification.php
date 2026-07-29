<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Notifications\BookingStatusNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBookingNotification implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    public $booking;

    public $actionType;

    public function __construct(Booking $booking, string $actionType)
    {
        $this->booking = $booking;
        $this->actionType = $actionType;
    }

    public function handle()
    {
        $this->booking->user->notify(new BookingStatusNotification($this->booking, $this->actionType));
    }
}
