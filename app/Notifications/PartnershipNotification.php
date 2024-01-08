<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PartnershipNotification extends Notification
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
        $jobTitle = $this->emailData['job_title'];
        $email = $this->emailData['email'];
        $companyName = $this->emailData['company_name'];
        $companyAddress = $this->emailData['company_address'];
        $county = $this->emailData['county'];
        $mobile = $this->emailData['mobile'];
        $employeeCount = $this->emailData['no_of_employee'];
        $interestReason = $this->emailData['why_interest'];
        $cloudProvider = $this->emailData['cloud_provider'];
        $cloudData = $this->emailData['cloud_data'];
        $partnership = $this->emailData['partnership'];
        $verticals = $this->emailData['verticals'];
        $expertise = $this->emailData['expertise'];
        $regionServed = $this->emailData['region_served'];

        return (new MailMessage)
            ->subject('Partnership Form Submission')
            ->greeting('Hi Kirsten!')
            ->line('A new partnership form has been submitted.')
            ->line('Here are the details:')
            ->line('Name: ' . $name)
            ->line('Job Title: ' . $jobTitle)
            ->line('Email: ' . $email)
            ->line('Company Name: ' . $companyName)
            ->line('Company Address: ' . $companyAddress)
            ->line('County: ' . $county)
            ->line('Mobile: ' . $mobile)
            ->line('Number of Employees: ' . $employeeCount)
            ->line('Reason for Interest: ' . $interestReason)
            ->line('Cloud Provider: ' . $cloudProvider)
            ->line('Cloud Data: ' . $cloudData)
            ->line('Partnership: ' . $partnership)
            ->line('Verticals: ' . $verticals)
            ->line('Expertise: ' . $expertise)
            ->line('Region Served: ' . $regionServed)
            ->line('Thank you for your submission.');
    }
}
