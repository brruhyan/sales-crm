<?php

namespace App\Filament\Client\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Section::make('Project Information')
                            ->description('Basic project details')
                            ->icon('heroicon-o-folder-open')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Project Name')
                                    ->icon('heroicon-o-document-text')
                                    ->copyable()
                                    ->columnSpan(1),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Notice to Proceed' => 'info',
                                        'Ongoing' => 'warning',
                                        'Finished' => 'success',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),

                                TextEntry::make('budget')
                                    ->label('Budget')
                                    ->money('PHP')
                                    ->weight('bold')
                                    ->color('success')
                                    ->columnSpan(1),

                                TextEntry::make('description')
                                    ->label('Description')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Associated Deal')
                            ->description('Deal information')
                            ->icon('heroicon-o-currency-dollar')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('deal.title')
                                    ->label('Deal Title')
                                    ->icon('heroicon-o-briefcase'),

                                TextEntry::make('deal.status')
                                    ->label('Deal Status')
                                    ->badge(),

                                TextEntry::make('deal.amount')
                                    ->label('Deal Value')
                                    ->money(fn ($record) => $record->deal?->currency ?? 'PHP'),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make()
                    ->schema([
                        Section::make('Timeline')
                            ->description('Project timeline')
                            ->icon('heroicon-o-clock')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('start_date')
                                    ->label('Start Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar')
                                    ->placeholder('Not set'),

                                TextEntry::make('end_date')
                                    ->label('End Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar')
                                    ->placeholder('Not set'),

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
