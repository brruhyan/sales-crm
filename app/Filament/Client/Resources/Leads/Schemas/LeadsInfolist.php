<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class LeadsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Section::make('Lead Details')
                            ->description('Lead and Company Information')
                            ->icon('heroicon-o-user-group')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('lead_title')
                                    ->label('Lead Title')
                                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                    ->copyable()
                                    ->columnSpan(1),
                                TextEntry::make('name')
                                    ->label('Name')
                                    ->icon('heroicon-o-user')
                                    ->copyable()
                                    ->columnSpan(1),

                                TextEntry::make('email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable()
                                    ->url(fn ($record) => "mailto:{$record->email}")
                                    ->columnSpan(1),

                                TextEntry::make('phone')
                                    ->label('Phone')
                                    ->icon('heroicon-o-phone')
                                    ->copyable()
                                    ->url(fn ($record) => "tel:{$record->phone}")
                                    ->columnSpan(1),

                                TextEntry::make('company')
                                    ->label('Company')
                                    ->icon('heroicon-o-building-office')
                                    ->placeholder('No company')
                                    ->columnSpan(1),
                            ]),

                        Section::make('Lead Status')
                            ->description('Source and current status')
                            ->icon('heroicon-o-chart-bar')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Current Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'New' => 'info',
                                        'Contacted' => 'warning',
                                        'Qualified' => 'success',
                                        'Lost' => 'danger',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),

                                TextEntry::make('source')
                                    ->label('Source')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Website' => 'primary',
                                        'Referral' => 'info',
                                        'Social Media' => 'success',
                                        'Event' => 'warning',
                                        'Cold Call' => 'gray',
                                        'Other' => 'gray',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}