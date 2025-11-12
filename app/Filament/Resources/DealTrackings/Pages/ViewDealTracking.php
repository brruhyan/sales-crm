<?php

namespace App\Filament\Resources\DealTrackings\Pages;

use App\Filament\Resources\DealTrackings\DealTrackingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDealTracking extends ViewRecord
{
    protected static string $resource = DealTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
