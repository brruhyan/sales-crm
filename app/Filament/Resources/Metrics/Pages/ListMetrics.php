<?php

namespace App\Filament\Resources\Metrics\Pages;

use App\Filament\Resources\Metrics\MetricsResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMetrics extends ListRecords
{
    protected static string $resource = MetricsResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
