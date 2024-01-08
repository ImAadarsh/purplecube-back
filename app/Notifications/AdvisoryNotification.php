<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdvisoryNotification extends Notification
{
    use Queueable;

    public $emailData;

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
        $name = $this->emailData['name'];
        $email = $this->emailData['email'];
        $companyName = $this->emailData['company_name'];
        $companyAddress = $this->emailData['company_address'];
        $country = $this->emailData['country'];
        $interested = $this->emailData['interested'];
        $feedback = $this->emailData['feedback'];

        return (new MailMessage)
            ->subject('Advisory Form Submission')
            ->greeting('Hello!')
            ->line('A new advisory form has been submitted.')
            ->line('Here are the details:')
            ->line('Name: ' . $name)
            ->line('Email: ' . $email)
            ->line('Company Name: ' . $companyName)
            ->line('Company Address: ' . $companyAddress)
            ->line('Country: ' . $country)
            ->line('Interested: ' . $interested)
            ->line('Feedback: ' . $feedback)
            ->line('Thank you for your submission.');
    }
}
