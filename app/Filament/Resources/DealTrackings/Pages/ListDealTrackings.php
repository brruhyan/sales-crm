<?php

namespace App\Filament\Resources\DealTrackings\Pages;

use App\Filament\Resources\DealTrackings\DealTrackingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDealTrackings extends ListRecords
{
    protected static string $resource = DealTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
