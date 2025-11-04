<?php

namespace App\Filament\Client\Actions;

use Filament\Actions\Action;
use App\Models\Leads;

class MarkLeadLostAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'markLost';
        
        return parent::make($name)
            ->label('Mark as Lost')
            ->color('danger')
            ->icon('heroicon-o-x-circle')
            ->requiresConfirmation()
            ->action(fn (Leads $record) => $record->update(['status' => 'Lost']));
    }
}
