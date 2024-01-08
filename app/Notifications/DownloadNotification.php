<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DownloadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $emailData;

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
        return (new MailMessage)
            ->subject('New Download Form Submission')
            ->greeting('Hi Kirsten!')
            ->line('A new download form submission has been received.')
            ->line('Here are the details:')
            ->line('Name: ' . $this->emailData['name'])
            ->line('Email: ' . $this->emailData['email'])
            ->line('Job Title: ' . $this->emailData['job_title'])
            ->line('Company Name: ' . $this->emailData['company_name'])
            ->line('Industry: ' . $this->emailData['industry'])
            ->line('Country: ' . $this->emailData['country'])
            ->line('Mobile: ' . $this->emailData['mobile'])
            ->line('Thank you!');
    }
}
