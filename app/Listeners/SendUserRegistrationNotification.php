<?php

namespace App\Listeners;

use Filament\Events\Auth\Registered;
use Filament\Notifications\Notification;

class SendUserRegistrationNotification
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        // Send notification to the user about pending approval
        Notification::make()
            ->title('Registration Successful')
            ->body('Your account has been created successfully. Please wait for an administrator to approve your account before you can access the platform.')
            ->success()
            ->persistent()
            ->send();
    }
}
