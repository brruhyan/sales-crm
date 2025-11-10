<?php

namespace App\Filament\Client\Actions;

use Filament\Actions\Action;
use App\Models\Deal;
use Filament\Notifications\Notification;

class MarkDealClosedWonAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'markWon';

        return parent::make($name)
            ->label('Mark as Won')
            ->color('success')
            ->visible(fn (Deal $record) => $record->status !== 'Deal Won')
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->action(function (Deal $record) {
                $record->update(['status' => 'Deal Won']);

                Notification::make()
                    ->title('Deal marked as Won.')
                    ->body('Congratulations! You can now keep track of this deal in the Projects section.')
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('success')
                    ->success()
                    ->send();
            });
    }
}
