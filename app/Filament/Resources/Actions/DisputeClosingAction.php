<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\Closing;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Textarea;
use App\Notifications\ClosingDisputeNotification;

class DisputeClosingAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'DisputeClosing';

        return parent::make($name)
            ->label('Dispute Closing')
            ->color('danger')
            ->icon('heroicon-o-x-circle')
            ->requiresConfirmation()
            ->visible(fn (Closing $record) => $record->status === 'Pending Review' || $record->status === 'Closed Won')
            ->form([
                Textarea::make('reason')
                    ->label('Reason for Dispute')
                    ->required()
                    ->placeholder('Explain why this closing is being disputed...'),
            ])

            ->action(function (Closing $record, array $data) {
                $record->update([
                    'status' => 'Disputed',
                    'dispute_reason' => $data['reason'],
                ]);

                $record->user->notify(new ClosingDisputeNotification($record->title, $data['reason']));

                Notification::make()
                    ->title('Closing disputed successfully.')
                    ->body("Reason: {$data['reason']}")
                    ->danger()
                    ->send();
            });
    }
}
