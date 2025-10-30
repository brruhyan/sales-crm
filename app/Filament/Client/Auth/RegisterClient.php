<?php

namespace App\Filament\Client\Pages\Auth;

use Filament\Pages\Auth\Register as BaseRegister;
use App\Models\User; 
use Illuminate\Auth\Events\Registered;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;

class RegisterClient extends BaseRegister 
{
    protected function handleRegistration(array $data): RegistrationResponse
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Hash::make($data['password']),
            'is_approved' => false, 
        ]);

        event(new Registered($user));.
        return app(RegistrationResponse::class);
    }
}