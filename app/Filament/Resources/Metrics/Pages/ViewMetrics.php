<?php

namespace App\Filament\Resources\Metrics\Pages;

use App\Filament\Resources\Metrics\MetricsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Widgets\DealsValuePerMonth;
use App\Filament\Widgets\DealsPerMonth;

class ViewMetrics extends ViewRecord
{
    protected static string $resource = MetricsResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [

        ];
    }
}
