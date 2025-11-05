<?php

namespace App\Filament\Client\Actions;

use Filament\Actions\Action;
use App\Models\Deal;
use Filament\Notifications\Notification;

class MarkDealClosedLostAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'markLost';

        return parent::make($name)
            ->label('Mark as Lost')
            ->color('danger')
            ->icon('heroicon-o-x-circle')
            ->requiresConfirmation()
            ->action(function (Deal $record) {
                $record->update(['status' => 'Lost']);

                Notification::make()
                    ->title('Deal marked as Lost.')
                    ->icon('heroicon-o-x-circle')
                    ->iconColor('danger')
                    ->success()
                    ->send();
            });
    }
}
