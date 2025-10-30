<?php

namespace App\Filament\Client\Resources\Leads;

use App\Filament\Client\Resources\Leads\Pages\CreateLeads;
use App\Filament\Client\Resources\Leads\Pages\EditLeads;
use App\Filament\Client\Resources\Leads\Pages\ListLeads;
use App\Filament\Client\Resources\Leads\Pages\ViewLeads;
use App\Filament\Client\Resources\Leads\Schemas\LeadsForm;
use App\Filament\Client\Resources\Leads\Schemas\LeadsInfolist;
use App\Filament\Client\Resources\Leads\Tables\LeadsTable;
use App\Models\Leads;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadsResource extends Resource
{
    protected static ?string $model = Leads::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Phone;

    public static string|UnitEnum|null $navigationGroup = 'Sales';

    protected static ?string $recordTitleAttribute = 'Leads';

    public static function form(Schema $schema): Schema
    {
        return LeadsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LeadsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeadsTable::configure($table);
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
            'index' => ListLeads::route('/'),
            'create' => CreateLeads::route('/create'),
            'view' => ViewLeads::route('/{record}'),
            'edit' => EditLeads::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
