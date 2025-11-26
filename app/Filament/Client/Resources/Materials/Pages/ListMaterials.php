<?php

namespace App\Filament\Client\Resources\Materials\Pages;

use App\Filament\Client\Resources\Materials\MaterialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
