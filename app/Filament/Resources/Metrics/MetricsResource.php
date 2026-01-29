<?php

namespace App\Filament\Resources\Metrics;

use App\Filament\Resources\Metrics\Pages\CreateMetrics;
use App\Filament\Resources\Metrics\Pages\EditMetrics;
use App\Filament\Resources\Metrics\Pages\ListMetrics;
use App\Filament\Resources\Metrics\Pages\ViewMetrics;
use App\Filament\Resources\Metrics\Schemas\MetricsForm;
use App\Filament\Resources\Metrics\Schemas\MetricsInfolist;
use App\Filament\Resources\Metrics\Tables\MetricsTable;
use App\Models\User;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MetricsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Summary';

    protected static ?string $modelLabel = 'Summary';

    protected static ?int $navigationSort = 10;

    protected static ?string $pluralModelLabel = 'Summary';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBar;

    public static function form(Schema $schema): Schema
    {
        return MetricsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MetricsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MetricsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return User::query();
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
            'index' => ListMetrics::route('/'),
            'create' => CreateMetrics::route('/create'),
            'view' => ViewMetrics::route('/{record}'),
            'edit' => EditMetrics::route('/{record}/edit'),
        ];
    }
}
