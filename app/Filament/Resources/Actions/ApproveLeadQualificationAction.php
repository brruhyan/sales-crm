<?php

namespace App\Filament\Resources\Actions;

use Filament\Actions\Action;
use App\Models\Leads;
use Filament\Notifications\Notification;
use App\Notifications\LeadApprovedNotification;

class ApproveLeadQualificationAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= 'approveLeadQualification';

        return parent::make($name)
            ->label('Approve Qualification')
            ->color('success')
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->visible(fn (Leads $record) => $record->status === 'For Review')
            ->action(function (Leads $record) {
                $record->update(['status' => 'Qualified']);

                $record->notify(new LeadApprovedNotification($record->lead_title));

                Notification::make()
                    ->title('Lead qualification approved successfully.')
                    ->success()
                    ->send();
            });
    }
}