<?php

namespace App\Filament\Client\Resources\Products\Tables;

use Filament\Actions\Action;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Hugomyb\FilamentMediaAction\Actions\MediaAction;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                TextColumn::make('product_name')
                    ->label('Service Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description),
                TextColumn::make('link')
                    ->label('Learn More')
                    ->color('info')
                    ->url(fn ($record) => $record->link)
                    ->openUrlInNewTab()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->link),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                MediaAction::make('download-media')
                    ->label('View Media')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->media(fn($record) => $record->media ? '/storage/' . $record->media : null)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->media)),
            ]);
    }
}
