<?php

namespace App\Filament\Resources\AddPartners;

use App\Filament\Resources\AddPartners\Pages\CreateAddPartner;
use App\Filament\Resources\AddPartners\Pages\EditAddPartner;
use App\Filament\Resources\AddPartners\Pages\ListAddPartners;
use App\Filament\Resources\AddPartners\Pages\ViewAddPartner;
use App\Filament\Resources\AddPartners\Schemas\AddPartnerForm;
use App\Filament\Resources\AddPartners\Schemas\AddPartnerInfolist;
use App\Filament\Resources\AddPartners\Tables\AddPartnersTable;
use App\Models\Partner;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AddPartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    public static string|UnitEnum|null $navigationGroup = 'Record Management';

    protected static ?string $navigationLabel = 'Partners';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Partner';

    protected static ?string $pluralModelLabel = 'Partners';

    public static function form(Schema $schema): Schema
    {
        return AddPartnerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AddPartnerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddPartnersTable::configure($table);
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
            'index' => ListAddPartners::route('/'),
            'create' => CreateAddPartner::route('/create'),
            'view' => ViewAddPartner::route('/{record}'),
            'edit' => EditAddPartner::route('/{record}/edit'),
        ];
    }
}
