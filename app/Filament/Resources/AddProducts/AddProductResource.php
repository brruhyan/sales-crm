<?php

namespace App\Filament\Resources\AddProducts;

use App\Filament\Resources\AddProducts\Pages\CreateAddProduct;
use App\Filament\Resources\AddProducts\Pages\EditAddProduct;
use App\Filament\Resources\AddProducts\Pages\ListAddProducts;
use App\Filament\Resources\AddProducts\Pages\ViewAddProduct;
use App\Filament\Resources\AddProducts\Schemas\AddProductForm;
use App\Filament\Resources\AddProducts\Schemas\AddProductInfolist;
use App\Filament\Resources\AddProducts\Tables\AddProductsTable;
use App\Models\ProductList;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AddProductResource extends Resource
{
    protected static ?string $model = ProductList::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;
    
    public static string|UnitEnum|null $navigationGroup = 'Record Management';

    protected static ?string $navigationLabel = 'Products';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Product';

    public static function form(Schema $schema): Schema
    {
        return AddProductForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AddProductInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAddProducts::route('/'),
            'create' => CreateAddProduct::route('/create'),
            'view' => ViewAddProduct::route('/{record}'),
            'edit' => EditAddProduct::route('/{record}/edit'),
        ];
    }
}
