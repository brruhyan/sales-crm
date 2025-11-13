<?php

namespace App\Filament\Resources\LeadTrackings\Pages;

use App\Filament\Resources\LeadTrackings\LeadTrackingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Actions\ApproveLeadQualificationAction;
use App\Filament\Resources\Actions\DisputeLeadAction;

class ViewLeadTracking extends ViewRecord
{
    protected static string $resource = LeadTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ApproveLeadQualificationAction::make(),
            DisputeLeadAction::make(),
        ];
    }
}
