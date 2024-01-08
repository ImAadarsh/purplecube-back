<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class ContactNotification extends Notification
{
    use Queueable;

    private $emailData;

    /**
     * Create a new notification instance.
     *
     * @param  array  $emailData
     * @return void
     */
    public function __construct(array $emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $emailData = $this->emailData;

        return (new MailMessage)
            ->subject('New Contact Form Submission')
            ->greeting('Hi Kirsten,')
            ->line('You have received a new contact form submission.')
            ->line('Here are the details:')
            ->line('Name: ' . $emailData['name'])
            ->line('Email: ' . $emailData['email'])
            ->line('Organization Name: ' . $emailData['organization_name'])
            ->line('Job Title: ' . $emailData['job_title'])
            ->line('Country: ' . $emailData['country'])
            ->line('Message: ' . $emailData['message'])
            ->line('Contact: ' . $emailData['contact']);
    }
}

