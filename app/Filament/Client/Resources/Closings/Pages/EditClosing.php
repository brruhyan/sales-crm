<?php

namespace App\Filament\Client\Resources\Closings\Pages;

use App\Filament\Client\Resources\Closings\ClosingResource;
use Filament\Resources\Pages\EditRecord;

class EditClosing extends EditRecord
{
    protected static string $resource = ClosingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
