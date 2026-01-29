<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClosingDisputeNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public string $closingTitle, public string $reason = '')
    {
        //
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
        return (new MailMessage)
            ->greeting('Attention Required!')
            ->line('Closing Disputed!')
            ->line(sprintf('Hello %s, your closing **"%s"** has been disputed.', $notifiable->name, $this->closingTitle))
            ->line(sprintf('**Reason:** %s', $this->reason))
            ->line('Please review the details and take necessary actions.')
            ->action('Review Now', url('/client/closings'))
            ->line('Thank you for using our application!');
    }
}
