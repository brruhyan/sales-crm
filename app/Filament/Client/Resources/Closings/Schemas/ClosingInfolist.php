<?php

namespace App\Filament\Client\Resources\Closings\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\BadgeEntry;

class ClosingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Closing Information')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('title')
                            ->label('Title')
                            ->columnSpan(2),

                        TextEntry::make('deal.title')
                            ->label('Associated Deal')
                            ->columnSpan(1),

                        TextEntry::make('status')
                            ->label('Status')
                            ->columnSpan(1),

                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpan(2),
                    ]),

                Section::make('Financial Details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('amount')
                            ->label('Amount')
                            ->prefix('$')
                            ->columnSpan(1),

                        TextEntry::make('currency')
                            ->label('Currency')
                            ->columnSpan(1),

                        TextEntry::make('probability')
                            ->label('Probability')
                            ->suffix('%')
                            ->columnSpan(1),
                    ]),

                Section::make('Timeline')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('expected_close_date')
                            ->label('Expected Close Date')
                            ->date()
                            ->columnSpan(1),

                        TextEntry::make('actual_close_date')
                            ->label('Actual Close Date')
                            ->date()
                            ->columnSpan(1),
                    ]),

                Section::make('Contact & Notes')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('contact.name')
                            ->label('Contact')
                            ->columnSpan(1),

                        TextEntry::make('notes')
                            ->label('Notes')
                            ->columnSpan(2),
                    ]),
            ]);
    }
}
