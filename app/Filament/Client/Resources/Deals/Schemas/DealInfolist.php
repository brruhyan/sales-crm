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
                Section::make()
                    ->schema([
                        Section::make('Deal Information')
                            ->description('Basic deal details')
                            ->icon('heroicon-o-document-text')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Deal Title')
                                    ->icon('heroicon-o-briefcase')
                                    ->copyable()
                                    ->columnSpan(1),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Prospecting' => 'gray',
                                        'Qualification' => 'info',
                                        'Needs Analysis' => 'primary',
                                        'Proposal' => 'warning',
                                        'Negotiation' => 'warning',
                                        'Closed Won' => 'success',
                                        'Closed Lost' => 'danger',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),

                                TextEntry::make('probability')
                                    ->label('Win Probability')
                                    ->formatStateUsing(fn ($state) => $state . '%')
                                    ->badge()
                                    ->color(fn ($state): string => match (true) {
                                        $state >= 75 => 'success',
                                        $state >= 50 => 'warning',
                                        $state >= 25 => 'info',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),

                                TextEntry::make('description')
                                    ->label('Description')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Financial Details')
                            ->description('Deal value and financial information')
                            ->icon('heroicon-o-currency-dollar')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('amount')
                                    ->label('Deal Value')
                                    ->money(fn ($record) => $record->currency)
                                    ->weight('bold')
                                    ->size('lg')
                                    ->color('success')
                                    ->columnSpan(1),

                                TextEntry::make('currency')
                                    ->label('Currency')
                                    ->badge()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make()
                    ->schema([
                        Section::make('Associations')
                            ->description('Contact and team member assignment')
                            ->icon('heroicon-o-users')
                            ->collapsed(false)
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

                                TextEntry::make('contact.company')
                                    ->label('Company')
                                    ->icon('heroicon-o-building-office'),

                                TextEntry::make('user.name')
                                    ->label('Assigned To')
                                    ->icon('heroicon-o-user-circle')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('source')
                                    ->label('Source')
                                    ->badge()
                                    ->icon('heroicon-o-link')
                                    ->color('gray'),
                            ]),

                        Section::make('Timeline')
                            ->description('Deal timeline and important dates')
                            ->icon('heroicon-o-clock')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('expected_close_date')
                                    ->label('Expected Close Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar'),

                                TextEntry::make('actual_close_date')
                                    ->label('Actual Close Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar-days')
                                    ->placeholder('Not closed yet'),

                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('M j, Y H:i:s')
                                    ->icon('heroicon-o-plus-circle'),

                                TextEntry::make('updated_at')
                                    ->label('Updated At')
                                    ->dateTime('M j, Y H:i:s')
                                    ->icon('heroicon-o-arrow-path'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}