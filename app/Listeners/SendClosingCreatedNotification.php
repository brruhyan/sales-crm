<?php

namespace App\Listeners;

use App\Models\Closing;
use App\Notifications\ClosingCreatedNotification;
use Illuminate\Events\Dispatcher;

class SendClosingCreatedNotification
{
    public function handle($event)
    {
        if ($event->model instanceof Closing && $event->model->wasRecentlyCreated) {
            $event->model->user->notify(new ClosingCreatedNotification($event->model));
        }
    }
}
