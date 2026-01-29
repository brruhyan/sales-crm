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
        $name ??= 'markDealForReview';

        return parent::make($name)
            ->label('Send for Review')
            ->color('success')
            ->visible(fn (Deal $record) => $record->status !== 'Deal Won' && $record->status !== 'For Review')
            ->icon('heroicon-o-check-circle')
            ->form([
                FileUpload::make('documents')
                    ->label('Proposal Documents')
                    ->required()
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
                    'status' => 'For Review',
                    'documents' => $data['documents'] ?? null,
                ]);

                Notification::make()
                    ->title('Sent for Review.')
                    ->body('Congratulations! Please wait for the review process to complete.')
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('success')
                    ->success()
                    ->send();
            });
    }
}
