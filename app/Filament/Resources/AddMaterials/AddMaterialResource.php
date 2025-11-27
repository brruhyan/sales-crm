<?php

namespace App\Filament\Resources\AddMaterials;

use App\Filament\Resources\AddMaterials\Pages\CreateAddMaterial;
use App\Filament\Resources\AddMaterials\Pages\EditAddMaterial;
use App\Filament\Resources\AddMaterials\Pages\ListAddMaterials;
use App\Filament\Resources\AddMaterials\Pages\ViewAddMaterial;
use App\Filament\Resources\AddMaterials\Schemas\AddMaterialForm;
use App\Filament\Resources\AddMaterials\Schemas\AddMaterialInfolist;
use App\Filament\Resources\AddMaterials\Tables\AddMaterialsTable;
use App\Models\Material;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AddMaterialResource extends Resource
{
    protected static ?string $model = Material::class;
    
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    
    public static string|UnitEnum|null $navigationGroup = 'Learning Management';

    protected static ?string $navigationLabel = 'Materials';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Material';

    public static function form(Schema $schema): Schema
    {
        return AddMaterialForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AddMaterialInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddMaterialsTable::configure($table);
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
            'index' => ListAddMaterials::route('/'),
            'create' => CreateAddMaterial::route('/create'),
            'view' => ViewAddMaterial::route('/{record}'),
            'edit' => EditAddMaterial::route('/{record}/edit'),
        ];
    }
}
