<?php

namespace App\Filament\Client\Resources\Products\Pages;

use App\Filament\Client\Resources\Products\ProductsResource;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Read-only list - no create action
        ];
    }
}
