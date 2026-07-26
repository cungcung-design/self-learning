<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailNotification extends Notification
{
    use Queueable;
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

   public function toMail(object $notifiable): MailMessage
{
    return (new MailMessage)
       ->subject('Booking Confirmation')
        ->greeting('Hello ' . $notifiable->name . '!')
        ->line('Your room booking has been confirmed.')
        ->line('Thank you for choosing our hotel!');

        }
    public function toArray(object $notifiable): array
    {
        return [
          
        ];
    }
}
