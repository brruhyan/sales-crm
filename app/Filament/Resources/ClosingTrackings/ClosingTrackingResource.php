<?php

namespace App\Filament\Resources\ClosingTrackings;

use App\Filament\Resources\ClosingTrackings\Pages\CreateClosingTracking;
use App\Filament\Resources\ClosingTrackings\Pages\EditClosingTracking;
use App\Filament\Resources\ClosingTrackings\Pages\ListClosingTrackings;
use App\Filament\Resources\ClosingTrackings\Pages\ViewClosingTracking;
use App\Filament\Resources\ClosingTrackings\Schemas\ClosingTrackingForm;
use App\Filament\Resources\ClosingTrackings\Schemas\ClosingTrackingInfolist;
use App\Filament\Resources\ClosingTrackings\Tables\ClosingTrackingsTable;
use App\Models\Closing;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use AlizHarb\ActivityLog\RelationManagers\ActivitiesRelationManager;

class ClosingTrackingResource extends Resource
{
    protected static ?string $model = Closing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CheckCircle;

    protected static ?string $navigationLabel = 'Closings';

    protected static ?string $modelLabel = 'Closings';

    protected static ?string $pluralModelLabel = 'Closings';

    public static string|UnitEnum|null $navigationGroup = 'Approval & Tracking';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Pending Review')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    protected static ?int $navigationSort = 31;

    public static function form(Schema $schema): Schema
    {
        return ClosingTrackingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClosingTrackingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClosingTrackingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClosingTrackings::route('/'),
            'create' => CreateClosingTracking::route('/create'),
            'view' => ViewClosingTracking::route('/{record}'),
            'edit' => EditClosingTracking::route('/{record}/edit'),
        ];
    }
}
