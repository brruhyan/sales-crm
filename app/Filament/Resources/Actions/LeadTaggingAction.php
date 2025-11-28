<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\Leads;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;

class LeadTaggingAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'LeadTagging';

        return parent::make($name)
            ->label('Tag Lead')
            ->color('success')
            ->icon('heroicon-o-check-circle')
            ->form([
                Select::make('tag')
                    ->label('Select Tag')
                    ->options([
                        'First' => 'First',
                        'Second' => 'Second',
                        'Third' => 'Third',
                    ])
                    ->required(),
            ])
            ->visible(fn (Leads $record) => $record->status === 'Qualified')
            ->action(function (Leads $record, array $data) {
                $record->update(['tag' => $data['tag']]);

                Notification::make()
                    ->title('Qualified lead tagged successfully as ' . $data['tag'] . '.')
                    ->success()
                    ->send();
            });
    }
}