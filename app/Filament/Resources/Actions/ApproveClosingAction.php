<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\Closing;
use Filament\Notifications\Notification;
use App\Notifications\ClosingApprovedNotification;

class ApproveClosingAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'approveClosing';

        return parent::make($name)
            ->label('Approve Closing')
            ->color('success')
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->visible(fn (Closing $record) => $record->status === 'Pending Review')
            ->action(function (Closing $record) {
                $record->update(['status' => 'Closed Won']);

                $record->user->notify(new ClosingApprovedNotification($record->title));

                Notification::make()
                    ->title('Closing approved successfully.')
                    ->success()
                    ->send();
            });
    }
}
