<?php

namespace App\Filament\Resources\AddProducts\Pages;

use App\Filament\Resources\AddProducts\AddProductResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAddProduct extends EditRecord
{
    protected static string $resource = AddProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
