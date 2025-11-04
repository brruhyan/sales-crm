<?php

namespace App\Filament\Client\Actions;

use Filament\Actions\Action;
use App\Models\Leads;
use Filament\Notifications\Notification;

class MarkLeadQualifiedAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'markQualified';
        
        return parent::make($name)
            ->label('Mark as Qualified')
            ->color('success')
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->action(function (Leads $record) {
                $record->update(['status' => 'Qualified']);

                Notification::make()
                    ->title('Lead marked as Qualified.')
                    ->body('Congratulations! You can now proceed to converting this lead into a deal.')
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('success')
                    ->success()
                    ->send();
            });
    }
}
