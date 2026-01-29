<?php

namespace App\Notifications;

use App\Models\Closing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClosingCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Closing $closing;

    public function __construct(Closing $closing)
    {
        $this->closing = $closing;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Closing Created')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new closing has been created.')
            ->line('Closing Title: ' . $this->closing->title)
            ->line('Associated Deal: ' . $this->closing->deal->title)
            ->line('Status: ' . $this->closing->status)
            ->action('View Closing', url('/admin/closings/' . $this->closing->id))
            ->line('Thank you for using our application!');
    }
}
