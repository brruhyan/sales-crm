<?php

namespace App\Filament\Client\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class ProductsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(4)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('product_name')
                            ->label('Service Name')
                            ->columnSpanFull()
                            ->size('lg')
                            ->weight('bold'),
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->prose()
                            ->size('md'),
                    ]),
                Section::make('Service Details')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('features')
                            ->label('Features')
                            ->columnSpan(2)
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem; padding: 0;"><li style="margin-bottom: 0.5rem;">' . implode('</li><li style="margin-bottom: 0.5rem;">', array_filter(array_map('trim', explode("\n", $state)))) . '</li></ul>' : 'N/A')
                            ->html(),
                        TextEntry::make('benefits')
                            ->label('Benefits')
                            ->columnSpan(2)
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem; padding: 0;"><li style="margin-bottom: 0.5rem;">' . implode('</li><li style="margin-bottom: 0.5rem;">', array_filter(array_map('trim', explode("\n", $state)))) . '</li></ul>' : 'N/A')
                            ->html(),
                    ]),

                Section::make('Service Details')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('features')
                            ->label('Features')
                            ->columnSpan(2)
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem; padding: 0;"><li style="margin-bottom: 0.5rem;">' . implode('</li><li style="margin-bottom: 0.5rem;">', array_filter(array_map('trim', explode("\n", $state)))) . '</li></ul>' : 'N/A')
                            ->html(),
                        TextEntry::make('benefits')
                            ->label('Benefits')
                            ->columnSpan(2)
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem; padding: 0;"><li style="margin-bottom: 0.5rem;">' . implode('</li><li style="margin-bottom: 0.5rem;">', array_filter(array_map('trim', explode("\n", $state)))) . '</li></ul>' : 'N/A')
                            ->html(),
                    ]),
            ]);
    }
}
