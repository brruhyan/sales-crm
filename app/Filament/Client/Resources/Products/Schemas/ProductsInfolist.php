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
                Section::make('Service Information')
                    ->description('Details about the service')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('product_name')
                            ->label('Service Name')
                            ->columnSpanFull(),
                        TextEntry::make('price')
                            ->label('Price')
                            ->money('PHP'),
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->prose(),
                    ]),

                Section::make('Service Details')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('features')
                            ->label('Features')
                            ->columnSpanFull()
                            ->prose()
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem;"><li>' . implode('</li><li>', array_filter(explode("\n", $state))) . '</li></ul>' : 'N/A')
                            ->html(),
                        TextEntry::make('benefits')
                            ->label('Benefits')
                            ->columnSpanFull()
                            ->prose()
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem;"><li>' . implode('</li><li>', array_filter(explode("\n", $state))) . '</li></ul>' : 'N/A')
                            ->html(),
                        TextEntry::make('use_cases')
                            ->label('Use Cases')
                            ->columnSpanFull()
                            ->prose()
                            ->formatStateUsing(fn ($state) => $state ? '<ul style="list-style-type: disc; margin-left: 1.5rem;"><li>' . implode('</li><li>', array_filter(explode("\n", $state))) . '</li></ul>' : 'N/A')
                            ->html(),
                    ]),

                Section::make('Additional Information')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('link')
                            ->label('Learn More')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->columnSpanFull(),

                    ]),
            ]);
    }
}
