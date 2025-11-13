<?php

namespace App\Filament\Resources\DealTrackings\Pages;

use App\Filament\Resources\DealTrackings\DealTrackingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Actions\ApproveDealAction;
use App\Filament\Resources\Actions\DisputeDealAction;

class ViewDealTracking extends ViewRecord
{
    protected static string $resource = DealTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ApproveDealAction::make(),
            DisputeDealAction::make(),
        ];
    }
}
