<?php

namespace App\Filament\Resources\AddProducts\Pages;

use App\Filament\Resources\AddProducts\AddProductResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAddProducts extends ListRecords
{
    protected static string $resource = AddProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
