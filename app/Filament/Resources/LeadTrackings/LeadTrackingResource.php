<?php

namespace App\Filament\Resources\LeadTrackings;

use App\Filament\Resources\LeadTrackings\Pages\CreateLeadTracking;
use App\Filament\Resources\LeadTrackings\Pages\EditLeadTracking;
use App\Filament\Resources\LeadTrackings\Pages\ListLeadTrackings;
use App\Filament\Resources\LeadTrackings\Pages\ViewLeadTracking;
use App\Filament\Resources\LeadTrackings\Schemas\LeadTrackingForm;
use App\Filament\Resources\LeadTrackings\Schemas\LeadTrackingInfolist;
use App\Filament\Resources\LeadTrackings\Tables\LeadTrackingsTable;
use App\Models\Leads;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LeadTrackingResource extends Resource
{
    protected static ?string $model = Leads::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Leads';
    
    protected static ?int $navigationSort = 20;

    protected static ?string $modelLabel = 'Leads';

    protected static ?string $pluralModelLabel =  'Leads';

    public static string|UnitEnum|null $navigationGroup = 'Approval & Tracking';

    public static function form(Schema $schema): Schema
    {
        return LeadTrackingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LeadTrackingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeadTrackingsTable::configure($table);
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
            'index' => ListLeadTrackings::route('/'),
            'create' => CreateLeadTracking::route('/create'),
            'view' => ViewLeadTracking::route('/{record}'),
            'edit' => EditLeadTracking::route('/{record}/edit'),
        ];
    }
}
