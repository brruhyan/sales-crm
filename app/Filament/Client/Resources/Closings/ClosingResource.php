<?php

namespace App\Filament\Client\Resources\Closings;

use App\Filament\Client\Resources\Closings\Pages\CreateClosing;
use App\Filament\Client\Resources\Closings\Pages\EditClosing;
use App\Filament\Client\Resources\Closings\Pages\ListClosings;
use App\Filament\Client\Resources\Closings\Pages\ViewClosing;
use App\Filament\Client\Resources\Closings\Schemas\ClosingForm;
use App\Filament\Client\Resources\Closings\Schemas\ClosingInfolist;
use App\Filament\Client\Resources\Closings\Tables\ClosingsTable;
use App\Models\Closing;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClosingResource extends Resource
{
    protected static ?string $model = Closing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CheckCircle;

    public static string|UnitEnum|null $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ClosingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClosingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClosingsTable::configure($table);
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
            'index' => ListClosings::route('/'),
            'create' => CreateClosing::route('/create'),
            'view' => ViewClosing::route('/{record}'),
            'edit' => EditClosing::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->where('user_id', Auth::id());
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::$model::where('status', 'Closed Won')
            ->where('user_id', Auth::id())
            ->count();

        return $count > 0 ? (string)$count : null;
    }
}
