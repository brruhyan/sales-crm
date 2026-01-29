<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClosingApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $closingTitle;

    public function __construct($closingTitle)
    {
        $this->closingTitle = $closingTitle;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Closing Approved')
            ->line('Your closing "' . $this->closingTitle . '" has been approved.')
            ->line('The closing status has been updated to Closed Won.')
            ->action('View Closing', url('/filament/client/closings'))
            ->line('Thank you for your submission!');
    }
}
