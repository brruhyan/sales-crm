<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\User;
use App\Notifications\UserDeniedNotification;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Textarea;

class DenyUserAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'denyUser';

        return parent::make($name)
            ->label('Deny User')
            ->color('danger')
            ->requiresConfirmation()
            ->icon('heroicon-o-x-circle')
            ->form([
                Textarea::make('reason')
                    ->label('Reason for Denial')
                    ->required()
                    ->columnSpanFull(),
            ])
            ->visible(fn (User $record) => ! $record->approved)
            ->action(function (User $record, array $data) {
                $record->update([
                    'approved' => false,
                    'deny_reason' => $data['reason'], 
                ]);

                $record->notify(new UserDeniedNotification($data['reason']));

                Notification::make()
                    ->title('User denied successfully.')
                    ->danger()
                    ->send();
            });
    }
}
