<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\Deal;
use Filament\Notifications\Notification;
use App\Notifications\DealApprovedNotification;

class ApproveDealAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'approveDeal';

        return parent::make($name)
            ->label('Approve Deal')
            ->color('success')
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->visible(fn (Deal $record) => $record->status === 'For Review')
            ->action(function (Deal $record) {
                $record->update(['status' => 'Deal Won']);

                // Send notification to the user who owns the deal
                $record->user->notify(new DealApprovedNotification($record->title));

                Notification::make()
                    ->title('Deal approved successfully.')
                    ->success()
                    ->send();
            });
    }
}