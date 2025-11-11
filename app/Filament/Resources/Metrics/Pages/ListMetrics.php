<?php

namespace App\Filament\Resources\Metrics\Pages;

use App\Filament\Resources\Metrics\MetricsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMetrics extends ListRecords
{
    protected static string $resource = MetricsResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
