<?php

namespace App\Filament\Client\Actions;

use Filament\Actions\Action;
use App\Models\Deal;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms;

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
            ->form([
                FileUpload::make('won_documents')
                    ->label('Winning Documents')
                    ->helperText('Upload documents that contributed to winning this deal.')
                    ->multiple()
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->disk('public')
                    ->directory('won-deal-documents')
                    ->visibility('public')
                    ->minFiles(0)
                    ->maxFiles(5)
                    ->downloadable()
                    ->openable()
                    ->previewable(true)
                    ->columnSpanFull(),
            ])
            ->action(function (Deal $record, array $data) {
                $record->update([
                    'status' => 'Deal Won',
                    'won_documents' => $data['won_documents'] ?? null,
                ]);

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
