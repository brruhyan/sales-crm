<?php

namespace App\Filament\Resources\DealTrackings;

use App\Filament\Resources\DealTrackings\Pages\CreateDealTracking;
use App\Filament\Resources\DealTrackings\Pages\EditDealTracking;
use App\Filament\Resources\DealTrackings\Pages\ListDealTrackings;
use App\Filament\Resources\DealTrackings\Pages\ViewDealTracking;
use App\Filament\Resources\DealTrackings\Schemas\DealTrackingForm;
use App\Filament\Resources\DealTrackings\Schemas\DealTrackingInfolist;
use App\Filament\Resources\DealTrackings\Tables\DealTrackingsTable;
use App\Models\Deal;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DealTrackingResource extends Resource
{
    protected static ?string $model = Deal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Square3Stack3d;

    protected static ?string $navigationLabel = 'Deal Tracking';

    protected static ?string $modelLabel = 'Deal Tracking';

    protected static ?string $pluralModelLabel = 'Deal Tracking';

    public static string|UnitEnum|null $navigationGroup = 'Metrics View';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return DealTrackingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DealTrackingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DealTrackingsTable::configure($table);
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
            'index' => ListDealTrackings::route('/'),
            'create' => CreateDealTracking::route('/create'),
            'view' => ViewDealTracking::route('/{record}'),
            'edit' => EditDealTracking::route('/{record}/edit'),
        ];
    }
}
