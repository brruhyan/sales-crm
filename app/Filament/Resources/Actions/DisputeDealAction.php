<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\Deal;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Textarea;

class DisputeDealAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'DisputeDeal';

        return parent::make($name)
            ->label('Dispute Deal')
            ->color('danger')
            ->icon('heroicon-o-x-circle')
            ->requiresConfirmation()
            ->visible(fn (Deal $record) => $record->status === 'For Review' || $record->status === 'Deal Won')
            ->form([
                Textarea::make('reason')
                    ->label('Reason for Dispute')
                    ->required()
                    ->placeholder('Explain why this lead qualification is being disputed...'),
            ])

            ->action(function (Deal $record, array $data) {
                $record->update([
                    'status' => 'Disputed',
                    'dispute_reason' => $data['reason'],
                ]);

                Notification::make()
                    ->title('Deal disputed successfully.')
                    ->body("Reason: {$data['reason']}")
                    ->danger()
                    ->send();
            });
    }
}