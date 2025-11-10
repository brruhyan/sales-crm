<?php

namespace App\Filament\Client\Resources\Products\Pages;

use App\Filament\Client\Resources\Products\ProductsResource;
use Filament\Resources\Pages\ViewRecord;

class ViewProducts extends ViewRecord
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
