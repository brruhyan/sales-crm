<?php

namespace App\Filament\Client\Resources\Materials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->label('Presentation Material')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('learn_more')
                    ->label('Learn More')
                    ->badge()
                    ->url(fn ($record) => $record->learn_more)
                    ->openUrlInNewTab()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->learn_more),
                
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('download-media')
                    ->label('View Media')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => $record->media ? '/storage/' . $record->media : null)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->media)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
