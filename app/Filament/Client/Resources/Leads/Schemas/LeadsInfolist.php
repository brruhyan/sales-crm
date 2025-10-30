<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Models\Leads;
use Filament\Infolists\Components\BadgeEntry;

class LeadsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Top boxes for status, source, company (symmetrical)
                Section::make('Lead Details')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('status')
                            ->label('Current Status')
                            ->color(fn ($record) => match ($record->status) {
                                'New' => 'primary',
                                'Contacted' => 'warning',
                                'Qualified' => 'success',
                                'Lost' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('source')
                            ->label('Source')
                            ->color(fn ($record) => match ($record->source) {
                                'Website' => 'primary',
                                'Referral' => 'info',
                                'Social Media' => 'success',
                                'Other' => 'gray',
                                default => 'gray',
                            }),
                        TextEntry::make('company')
                            ->label('Company')
                            ->color('gray'),
                    ]),
                Section::make('Contact Details')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('phone')->label('Phone'),
                    ]),
            ]);
    }
}
