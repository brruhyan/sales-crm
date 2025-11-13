<?php

namespace App\Filament\Resources\LeadTrackings\Pages;

use App\Filament\Resources\LeadTrackings\LeadTrackingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLeadTracking extends EditRecord
{
    protected static string $resource = LeadTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
