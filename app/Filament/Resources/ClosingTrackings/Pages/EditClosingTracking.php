<?php

namespace App\Filament\Resources\ClosingTrackings\Pages;

use App\Filament\Resources\ClosingTrackings\ClosingTrackingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClosingTracking extends EditRecord
{
    protected static string $resource = ClosingTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
