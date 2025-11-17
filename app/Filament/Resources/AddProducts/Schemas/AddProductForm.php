<?php

namespace App\Filament\Resources\AddProducts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class AddProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Product Name')
                    ->required(),
            ]);
    }
}
