<?php

namespace App\Filament\Client\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;

class ProductsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(1)
                    ->schema([
                        TextEntry::make('product_name')
                            ->label('Service Name')
                            ->columnSpanFull()
                            ->size('lg')
                            ->weight('bold'),
                        TextEntry::make('company_name')
                            ->label('Company Name')
                            ->columnSpanFull()
                            ->color('gray'),
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->prose()
                            ->size('md'),
                    ]),

                Section::make('FEATURES')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('features')
                            ->label('')
                            ->columnSpanFull()
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem; padding: 0;"><li style="margin-bottom: 0.5rem;">' . implode('</li><li style="margin-bottom: 0.5rem;">', array_filter(array_map('trim', explode("\n", $state)))) . '</li></ul>' : 'N/A')
                            ->html(),
                    ]),

                Section::make('BENEFITS')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('benefits')
                            ->label('')
                            ->columnSpanFull()
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem; padding: 0;"><li style="margin-bottom: 0.5rem;">' . implode('</li><li style="margin-bottom: 0.5rem;">', array_filter(array_map('trim', explode("\n", $state)))) . '</li></ul>' : 'N/A')
                            ->html(),
                    ]),

                Section::make('USE CASES')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('use_cases')
                            ->label('')
                            ->columnSpanFull()
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem; padding: 0;"><li style="margin-bottom: 0.5rem;">' . implode('</li><li style="margin-bottom: 0.5rem;">', array_filter(array_map('trim', explode("\n", $state)))) . '</li></ul>' : 'N/A')
                            ->html(),
                    ]),

                Section::make()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('price')
                            ->label('Price')
                            ->money('PHP'),
                        TextEntry::make('link')
                            ->label('Learn More')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
