<?php

namespace App\Filament\Resources\ClosingTrackings\Pages;

use App\Filament\Resources\ClosingTrackings\ClosingTrackingResource;
use App\Filament\Resources\Actions\ApproveClosingAction;
use App\Filament\Resources\Actions\DisputeClosingAction;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewClosingTracking extends ViewRecord
{
    protected static string $resource = ClosingTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ApproveClosingAction::make(),
            DisputeClosingAction::make(),
            Actions\EditAction::make(),
        ];
    }
}
