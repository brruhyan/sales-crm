<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\User;
use Filament\Notifications\Notification;

class ApproveUserAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'approveUser';

        return parent::make($name)
            ->label('Approve User')
            ->color('success')
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->visible(fn (User $record) => ! $record->approved)
            ->action(function (User $record) {
                $record->update(['approved' => true]);

                Notification::make()
                    ->title('User approved successfully.')
                    ->success()
                    ->send();
            });
    }
}
