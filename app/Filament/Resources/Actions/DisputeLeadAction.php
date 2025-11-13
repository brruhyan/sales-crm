<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\Leads;
use Filament\Notifications\Notification;

class DisputeLeadAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'DisuputeLead';

        return parent::make($name)
            ->label('Dispute Qualification')
            ->color('danger')
            ->icon('heroicon-o-x-circle')
            ->requiresConfirmation()
            ->visible(fn (Leads $record) => $record->status === 'For Review')
            ->action(function (Leads $record) {
                $record->update(['status' => 'Disputed']);

                Notification::make()
                    ->title('Lead qualification disputed successfully.')
                    ->danger()
                    ->send();
            });
    }
}