<?php

namespace App\Filament\Client\Resources\Deals\Pages;

use App\Filament\Client\Resources\Deals\DealResource;
use Filament\Actions;
use App\Filament\Client\Widgets\DealsWidget;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Client\Widgets\DealsWidget;

class ListDeals extends ListRecords
{
    protected static string $resource = DealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
        protected function getHeaderWidgets(): array
    {
        return [
            DealsWidget::class,
        ];
    }
}
