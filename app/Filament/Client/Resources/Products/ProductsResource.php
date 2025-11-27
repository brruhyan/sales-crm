<?php

namespace App\Filament\Client\Resources\Products;

use App\Filament\Client\Resources\Products\Pages\ListProducts;
use App\Filament\Client\Resources\Products\Pages\ViewProducts;
use App\Filament\Client\Resources\Products\Schemas\ProductsInfolist;
use App\Filament\Client\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShoppingBag;

    public static string|UnitEnum|null $navigationGroup = 'Knowledge Base';

    protected static ?string $navigationLabel = 'Product Guide';

    protected static ?string $pluralModelLabel = 'Product Guide';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return ProductsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
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
            'index' => ListProducts::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery();
    }
}
