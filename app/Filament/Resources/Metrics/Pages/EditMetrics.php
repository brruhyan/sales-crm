<?php

namespace App\Filament\Resources\Metrics\Pages;

use App\Filament\Resources\Metrics\MetricsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMetrics extends EditRecord
{
    protected static string $resource = MetricsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
