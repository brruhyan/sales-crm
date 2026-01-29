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
                Section::make()
                    ->schema([
                        Section::make('Closing Information')
                            ->description('Basic closing details')
                            ->icon('heroicon-o-document-text')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Title')
                                    ->icon('heroicon-o-briefcase')
                                    ->copyable()
                                    ->columnSpan(1),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Open' => 'primary',
                                        'In Progress' => 'info',
                                        'Pending Documentation' => 'warning',
                                        'Closed Won' => 'success',
                                        'Closed Lost' => 'danger',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),

                                TextEntry::make('deal.title')
                                    ->label('Associated Deal')
                                    ->icon('heroicon-o-link')
                                    ->badge()
                                    ->columnSpan(1),

                                TextEntry::make('description')
                                    ->label('Description')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Financial Details')
                            ->description('Closing value and financial information')
                            ->icon('heroicon-o-currency-dollar')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('amount')
                                    ->label('Amount')
                                    ->money('USD')
                                    ->weight('bold')
                                    ->size('lg')
                                    ->color('success')
                                    ->columnSpan(1),

                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make()
                    ->schema([
                        Section::make('Associations')
                            ->description('Contact and related information')
                            ->icon('heroicon-o-users')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('contact.name')
                                    ->label('Contact')
                                    ->icon('heroicon-o-user')
                                    ->url(fn ($record) => $record->contact ? route('filament.client.resources.contacts.view', $record->contact) : null),

                                TextEntry::make('contact.email')
                                    ->label('Contact Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable()
                                    ->url(fn ($record) => $record->contact ? "mailto:{$record->contact->email}" : null),

                                TextEntry::make('contact.phone')
                                    ->label('Contact Phone')
                                    ->icon('heroicon-o-phone')
                                    ->copyable()
                                    ->url(fn ($record) => $record->contact ? "tel:{$record->contact->phone}" : null),
                            ]),

                        Section::make('Timeline')
                            ->description('Important dates')
                            ->icon('heroicon-o-clock')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('expected_close_date')
                                    ->label('Expected Close Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar')
                                    ->placeholder('Not set'),

                                TextEntry::make('actual_close_date')
                                    ->label('Actual Close Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar-days')
                                    ->placeholder('Not closed yet'),
                            ]),

                        Section::make('Additional Information')
                            ->description('Notes and supporting details')
                            ->icon('heroicon-o-document-plus')
                            ->columns(1)
                            ->schema([
                                TextEntry::make('notes')
                                    ->label('Notes')
                                    ->placeholder('No notes added.')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
