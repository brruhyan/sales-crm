<?php

namespace App\Filament\Client\Actions;

use Filament\Actions\Action;
use App\Models\Leads;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms;

class MarkLeadQualifiedAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'markQualified';
        
        return parent::make($name)
            ->label('Mark as Qualified')
            ->color('success')
            ->visible(fn (Leads $record) => $record->status !== 'Qualified')
            ->icon('heroicon-o-check-circle')
            ->form([
                FileUpload::make('qualified_documents')
                    ->label('Qualifying Documents')
                    ->helperText('Upload documents that qualify this lead.')
                    ->multiple()
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->disk('public')
                    ->directory('qualified-lead-documents')
                    ->visibility('public')
                    ->minFiles(0)
                    ->maxFiles(5)
                    ->downloadable()
                    ->openable()
                    ->previewable(true)
                    ->columnSpanFull(),
            ])
            ->action(function (Leads $record, array $data) {
                $record->update([
                    'status' => 'Qualified',
                    'qualified_documents' => $data['qualified_documents'] ?? null,
                ]);

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
