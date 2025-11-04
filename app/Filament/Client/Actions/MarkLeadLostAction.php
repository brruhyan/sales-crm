<?php

namespace App\Filament\Client\Actions;

use Filament\Actions\Action;
use App\Models\Leads;
use Filament\Notifications\Notification;

class MarkLeadLostAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'markLost';
        
        return parent::make($name)
            ->label('Mark as Lost')
            ->color('danger')
            ->icon('heroicon-o-x-circle')
            ->requiresConfirmation()
            ->action(function (Leads $record) {
                $record->update(['status' => 'Lost']);

                Notification::make()
                    ->title('Lead marked as Lost.')
                    ->icon('heroicon-o-x-circle')
                    ->iconColor('danger')
                    ->success()
                    ->send();
            });
    }
}
