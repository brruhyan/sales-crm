<?php

namespace App\Filament\Resources\AddMaterials\Pages;

use App\Filament\Resources\AddMaterials\AddMaterialResource;
use Filament\Resources\Pages\ListRecords;

class ListAddMaterials extends ListRecords
{
    protected static string $resource = AddMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
