<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingReceivedNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        if ($notifiable instanceof AnonymousNotifiable) {
            return ['mail'];
        }

        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->booking->loadMissing('room');

        return (new MailMessage)
            ->subject('We received your booking request')
            ->greeting('Hello '.$this->booking->name.'!')
            ->line('Thank you for booking '.$this->booking->room?->room_name.'.')
            ->line('Check-in: '.$this->booking->start_date?->toFormattedDateString())
            ->line('Check-out: '.$this->booking->end_date?->toFormattedDateString())
            ->line('Nights: '.$this->booking->nights())
            ->line('Estimated total: $'.number_format($this->booking->totalAmount(), 2))
            ->line('Your request is pending confirmation from our team. We will email you once it is reviewed.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'status' => $this->booking->status,
        ];
    }
}
