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
                // Top boxes for status, source, company
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
                // Lead Progress section
                Section::make('Lead Progress')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime()
                            ->icon('heroicon-o-plus'),
                        TextEntry::make('updated_at')
                            ->label('Updated')
                            ->dateTime()
                            ->icon('heroicon-o-pencil'),
                        TextEntry::make('deleted_at')
                            ->label('Deleted')
                            ->dateTime()
                            ->icon('heroicon-o-trash')
                            ->hidden(fn ($record) => !$record->deleted_at),
                    ]),
                // Other details
                Section::make('Contact Details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('phone')->label('Phone'),
                    ]),
            ]);
    }
}
