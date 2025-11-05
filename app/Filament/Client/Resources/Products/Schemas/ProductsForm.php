<?php

namespace App\Filament\Client\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class ProductsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Information')
                    ->description('Details about the product')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('product_name')
                            ->label('Product Name')
                            ->columnSpanFull()
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->label('Description'),
                Grid::make(1)
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('price')
                            ->label('Price')
                            ->prefix('₱')
                            ->numeric()
                            ->required(),
                        Toggle::make('sellable')
                            ->label('Authorized Seller')
                            ->default(true),
                    ]),

                    ])
            ]);
    }
}
