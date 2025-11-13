<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\Deal;
use Filament\Notifications\Notification;

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

                Notification::make()
                    ->title('Deal approved successfully.')
                    ->success()
                    ->send();
            });
    }
}