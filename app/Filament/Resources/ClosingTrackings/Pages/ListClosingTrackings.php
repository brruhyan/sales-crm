<?php

namespace App\Filament\Resources\ClosingTrackings\Pages;

use App\Filament\Resources\ClosingTrackings\ClosingTrackingResource;
use Filament\Resources\Pages\ListRecords;

class ListClosingTrackings extends ListRecords
{
    protected static string $resource = ClosingTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
