<?php

namespace App\Filament\Resources\AddPartners\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use app\Models\Contact;

class AddPartnerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([ 
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Section::make('Partner Information')
                            ->description('Basic partner details')
                            ->icon('heroicon-o-document-text')
                            ->columns(2)
                            ->columnSpanFull()
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Partner Name')
                                    ->icon('heroicon-o-briefcase')
                                    ->copyable()
                                    ->columnSpan(1),
                                TextEntry::make('company_address')
                                    ->label('Address')
                                    ->icon('heroicon-o-map-pin')
                                    ->copyable()
                                    ->state(fn ($record) => $record->contacts()->first()?->company_address ?? 'N/A')
                                    ->columnSpan(1),
                            ]),
                    ]), 
            ]); 
    }
}