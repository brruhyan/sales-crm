<?php

namespace App\Filament\Resources\DealTrackings\Pages;

use App\Filament\Resources\DealTrackings\DealTrackingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDealTracking extends EditRecord
{
    protected static string $resource = DealTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
