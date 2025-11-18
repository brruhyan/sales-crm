<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Filament\Events\Auth\Registered;
use App\Listeners\SendUserRegistrationNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            Registered::class,
            SendUserRegistrationNotification::class,
        );
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
    }
}
