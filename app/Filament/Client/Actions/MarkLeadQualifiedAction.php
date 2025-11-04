<?php

namespace App\Filament\Client\Actions;

use Filament\Actions\Action;
use App\Models\Leads;

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
            ->action(fn (Leads $record) => $record->update(['status' => 'Qualified']));
    }
}
