<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserDeniedNotification extends Notification
{
    use Queueable;

    public function __construct(public string $deny_reason)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('User Registration Denied')
            ->greeting('We\'re Sorry!')
            ->line('User Registration Denied!.')
            ->line(sprintf(
                'Hello %s, your registration has been denied. Reason: **"%s"**',
                $notifiable->name,
                $notifiable->deny_reason
            ))
            ->action('Resubmit Registration', url('/client/register'))
            ->line('You may resubmit your registration after addressing the issues mentioned.')
            ->line('Thank you for your understanding.');
    }
    
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
