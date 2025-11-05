<?php

namespace App\Filament\Client\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class ProductsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Information')
                    ->description('Details about the product')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('product_name')
                            ->label('Product Name')
                            ->required(),
                        Textarea::make('description')
                            ->label('Description'),
                        TextInput::make('price')
                            ->label('Price')
                            ->columnSpan(1)
                            ->prefix('₱')
                            ->numeric()
                            ->required(),
                        Toggle::make('sellable')
                            ->label('Sellable')
                            ->default(true),
                    ]),
            ]);
    }
}
