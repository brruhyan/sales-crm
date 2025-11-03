<?php

namespace App\Filament\Client\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Notifications\Notification;

class Register extends BaseRegister
{
    protected function afterRegister(): void
    {
        Notification::make()
            ->title('Registration Successful')
            ->body('Your account has been created successfully. Please wait for an administrator to approve your account before you can login.')
            ->success()
            ->persistent()
            ->send();
    }
}
