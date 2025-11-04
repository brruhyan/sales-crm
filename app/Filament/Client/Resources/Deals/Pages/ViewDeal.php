<?php

namespace App\Filament\Client\Resources\Deals\Pages;

use App\Filament\Client\Resources\Deals\DealResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Client\Actions\MarkDealClosedWonAction;
use App\Filament\Client\Actions\MarkDealClosedLostAction;

class ViewDeal extends ViewRecord
{
    protected static string $resource = DealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            MarkDealClosedWonAction::make(),
            MarkDealClosedLostAction::make(),
        ];
    }
}
