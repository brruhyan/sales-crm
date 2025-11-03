<?php

namespace App\Filament\Client\Resources\Deals\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class DealInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Deal Information')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('title')
                            ->label('Deal Title'),
                        
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Prospecting' => 'gray',
                                'Qualification' => 'info',
                                'Proposal' => 'warning',
                                'Negotiation' => 'warning',
                                'Closed Won' => 'success',
                                'Closed Lost' => 'danger',
                                default => 'gray',
                            }),
                        
                        TextEntry::make('probability')
                            ->label('Win Probability')
                            ->suffix('%'),

                        TextEntry::make('description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Financial Details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('amount')
                            ->label('Deal Value')
                            ->money(fn ($record) => $record->currency ?? 'PHP'),
                        
                        TextEntry::make('currency'),
                    ]),

                Section::make('Associations')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('contact.name')
                            ->label('Contact'),
                        
                        TextEntry::make('contact.email')
                            ->label('Contact Email'),

                        TextEntry::make('contact.phone')
                            ->label('Contact Phone'),

                        TextEntry::make('contact.company')
                            ->label('Company'),

                        TextEntry::make('user.name')
                            ->label('Assigned To'),

                        TextEntry::make('source')
                            ->label('Source'),
                    ]),

                Section::make('Timeline')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('expected_close_date')
                            ->date(),

                        TextEntry::make('actual_close_date')
                            ->date(),

                        TextEntry::make('created_at')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ]),
            ]);
    }
}
