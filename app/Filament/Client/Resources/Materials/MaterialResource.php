<?php

namespace App\Filament\Client\Resources\Materials;

use App\Filament\Client\Resources\Materials\Pages\CreateMaterial;
use App\Filament\Client\Resources\Materials\Pages\EditMaterial;
use App\Filament\Client\Resources\Materials\Pages\ListMaterials;
use App\Filament\Client\Resources\Materials\Pages\ViewMaterial;
use App\Filament\Client\Resources\Materials\Schemas\MaterialForm;
use App\Filament\Client\Resources\Materials\Schemas\MaterialInfolist;
use App\Filament\Client\Resources\Materials\Tables\MaterialsTable;
use App\Models\Material;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;

    public static string|UnitEnum|null $navigationGroup = 'Knowledge Base';

    protected static ?string $navigationLabel = 'Materials';

    protected static ?string $pluralModelLabel = 'Materials';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return MaterialForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MaterialInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaterialsTable::configure($table);
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
            'index' => ListMaterials::route('/'),
            'create' => CreateMaterial::route('/create'),
            'view' => ViewMaterial::route('/{record}'),
            'edit' => EditMaterial::route('/{record}/edit'),
        ];
    }
}
