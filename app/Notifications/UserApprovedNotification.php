<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Services\CertificateService;

class UserApprovedNotification extends Notification
{
    use Queueable;

    protected $certificateService;
    protected $certificatePath;

    /**
     * Create a new notification instance.
     */
    public function __construct(?string $certificatePath = null)
    {
        $this->certificatePath = $certificatePath;
        $this->certificateService = new CertificateService();
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
        $mailMessage = (new MailMessage)
            ->line('User Registration Approved!')
            ->greeting('Congratulations!')
            ->line(sprintf('Hello %s, your registration has been approved. You can now log in to your account.', $notifiable->name))
            ->line('We are excited to have you on board!')
            ->line('Please find your registration certificate attached to this email.')
            ->action('Login Now', url('/client'))
            ->line('Thank you for joining us!');

        // Attach the certificate if provided
        if ($this->certificatePath) {
            $fullPath = $this->certificateService->getCertificatePath($this->certificatePath);
            if (file_exists($fullPath)) {
                $mailMessage->attach($fullPath, [
                    'as' => 'Registration_Certificate_' . $notifiable->name . '.pdf',
                    'mime' => 'application/pdf',
                ]);
            }
        }

        return $mailMessage;
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
