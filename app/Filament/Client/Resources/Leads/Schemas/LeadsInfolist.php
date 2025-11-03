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
                                    ->columnSpanFull(),
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

                Section::make()
                    ->schema([
                        Section::make('Timestamps')
                            ->description('Lead creation and update information')
                            ->icon('heroicon-o-clock')
                            ->columns(2)
                            ->schema([
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