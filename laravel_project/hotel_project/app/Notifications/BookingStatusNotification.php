<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusNotification extends Notification
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

        $guestName = $this->booking->name ?: 'Guest';
        $roomName = $this->booking->room?->room_name ?? 'your selected room';
        $status = $this->booking->status;

        $message = (new MailMessage)
            ->subject('Booking '.ucfirst($status))
            ->greeting('Hello '.$guestName.'!')
            ->line('Your booking for '.$roomName.' is now '.$status.'.')
            ->line('Check-in: '.$this->booking->start_date?->toFormattedDateString())
            ->line('Check-out: '.$this->booking->end_date?->toFormattedDateString())
            ->line('Nights: '.$this->booking->nights())
            ->line('Estimated total: $'.number_format($this->booking->totalAmount(), 2));

        if ($this->booking->isApproved()) {
            $message->line('We look forward to welcoming you.');
        } elseif ($this->booking->isCancelled()) {
            $message->line('This reservation has been cancelled. You can book another stay at any time.');
        } else {
            $message->line('If you have questions, reply to this email or contact the hotel.');
        }

        return $message;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'status' => $this->booking->status,
            'room_id' => $this->booking->room_id,
        ];
    }
}
