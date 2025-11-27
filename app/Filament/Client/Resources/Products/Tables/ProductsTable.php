<?php

namespace App\Filament\Client\Resources\Products\Tables;

use Filament\Actions\Action;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

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
                    ->url(fn ($record) => $record->link)
                    ->openUrlInNewTab()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->link),
                IconColumn::make('media')
                    ->label('Media')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-arrow-down')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->getStateUsing(fn ($record) => !empty($record->media)),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('download-media')
                    ->label('View Media')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => $record->media ? asset('storage/' . $record->media) : null)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->media)),
            ]);
    }
}
