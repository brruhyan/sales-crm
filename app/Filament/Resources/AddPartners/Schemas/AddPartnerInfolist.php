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
                        Section::make('Company Information')
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
                                Section::make('Contact Person Name ')
                                    ->description('Primary contact for this partner')
                                    ->icon('heroicon-o-document-text')
                                    ->columns(2)
                                    ->columnSpanFull()
                                    ->schema([
                                        TextEntry::make('contact.name')
                                            ->label('Contact Person Name')
                                            ->icon('heroicon-o-briefcase')
                                            ->state(fn ($record) => $record->contacts()->first()?->name ?? 'N/A')
                                            ->copyable()
                                            ->columnSpan(1),
                                        TextEntry::make('contact.position')
                                            ->label('Position')
                                            ->icon('heroicon-o-briefcase')
                                            ->copyable()
                                            ->state(fn ($record) => $record->contacts()->first()?->position ?? 'N/A')
                                            ->columnSpan(1),
                                    ]),
                    ]), 
  
            ]); 
    }
}