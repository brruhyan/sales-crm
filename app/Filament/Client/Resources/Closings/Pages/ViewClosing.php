<?php

namespace App\Filament\Client\Resources\Closings\Pages;

use App\Filament\Client\Resources\Closings\ClosingResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewClosing extends ViewRecord
{
    protected static string $resource = ClosingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
        ];
    }
}
