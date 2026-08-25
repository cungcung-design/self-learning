<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactReplyNotification extends Notification
{
    use Queueable;

    /**
     * @param  array{greeting: string, body: string, action_text?: string|null, action_url?: string|null, end_line?: string|null}  $mail
     */
    public function __construct(
        public Contact $contact,
        public array $mail
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Reply from our hotel')
            ->greeting($this->mail['greeting'])
            ->line($this->mail['body']);

        if (! empty($this->mail['action_text']) && ! empty($this->mail['action_url'])) {
            $message->action($this->mail['action_text'], $this->mail['action_url']);
        }

        if (! empty($this->mail['end_line'])) {
            $message->line($this->mail['end_line']);
        }

        return $message;
    }
}
