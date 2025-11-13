<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use App\Models\Leads;
use Filament\Notifications\Notification;

class DisputeLeadAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'DisputeLead';

        return parent::make($name)
            ->label('Dispute Qualification')
            ->color('danger')
            ->icon('heroicon-o-x-circle')
            ->requiresConfirmation()
            ->visible(fn (Leads $record) => $record->status === 'For Review')
            ->form([
                Textarea::make('reason')
                    ->label('Reason for Dispute')
                    ->required()
                    ->placeholder('Explain why this lead qualification is being disputed...'),
            ])
            ->action(function (Leads $record, array $data) {
                $record->update([
                    'status' => 'Disputed',
                    'dispute_reason' => $data['reason'],
                ]);

                Notification::make()
                    ->title('Lead qualification disputed successfully.')
                    ->body("Reason: {$data['reason']}")
                    ->danger()
                    ->send();
            });
    }
}
