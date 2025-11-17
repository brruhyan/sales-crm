<?php

namespace App\Filament\Resources\AddProducts\Pages;

use App\Filament\Resources\AddProducts\AddProductResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAddProduct extends ViewRecord
{
    protected static string $resource = AddProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
