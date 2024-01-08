<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResourceAccessForm extends Notification
{
    use Queueable;
    private $emailData;
    /**
     * Create a new notification instance.
     */
    public function __construct(array $emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $emailData = $this->emailData;

        return (new MailMessage)
            ->subject('New Email Form Submission')
            ->greeting('Hi Kirsten,')
            ->line('You have received a new Resource Access Form submission.')
            ->line('Here are the details:')
            ->line('Email: ' . $emailData['email']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
