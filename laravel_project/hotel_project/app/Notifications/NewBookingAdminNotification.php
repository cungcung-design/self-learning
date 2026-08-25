<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingAdminNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->booking->loadMissing('room');

        return (new MailMessage)
            ->subject('New booking request #'.$this->booking->id)
            ->greeting('Hello '.$notifiable->name.',')
            ->line($this->booking->name.' requested '.$this->booking->room?->room_name.'.')
            ->line('Check-in: '.$this->booking->start_date?->toFormattedDateString())
            ->line('Check-out: '.$this->booking->end_date?->toFormattedDateString())
            ->action('Review booking', url('/panel/bookings'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'guest' => $this->booking->name,
            'status' => $this->booking->status,
        ];
    }
}
