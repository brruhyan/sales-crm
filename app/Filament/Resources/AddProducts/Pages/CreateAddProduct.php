<?php

namespace App\Filament\Resources\AddProducts\Pages;

use App\Filament\Resources\AddProducts\AddProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAddProduct extends CreateRecord
{
    protected static string $resource = AddProductResource::class;
}
