<?php

namespace App\Filament\Client\Actions;

use Filament\Actions\Action;
use App\Models\Closing;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;

class SendClosingForReviewAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'sendClosingForReview';

        return parent::make($name)
            ->label('Send for Review')
            ->color('success')
            ->visible(fn (Closing $record) => $record->status !== 'Closed Won' && $record->status !== 'Closed Lost' && $record->status !== 'Pending Review')
            ->icon('heroicon-o-check-circle')
            ->form([
                FileUpload::make('documents')
                    ->label('Supporting Documents')
                    ->helperText('Upload documents that support this closing.')
                    ->multiple()
                    ->disk('public')
                    ->directory('closing-documents')
                    ->visibility('public')
                    ->minFiles(0)
                    ->maxFiles(10)
                    ->downloadable()
                    ->openable()
                    ->previewable(true)
                    ->columnSpanFull(),
            ])
            ->action(function (Closing $record, array $data) {
                if (!empty($data['documents'])) {
                    $existingDocuments = $record->documents ?? [];
                    $record->update([
                        'status' => 'Pending Review',
                        'documents' => array_merge($existingDocuments, $data['documents']),
                    ]);
                } else {
                    $record->update([
                        'status' => 'Pending Review',
                    ]);
                }

                Notification::make()
                    ->title('Sent for Review.')
                    ->body('Your closing has been sent for admin review.')
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('success')
                    ->success()
                    ->send();
            });
    }
}
