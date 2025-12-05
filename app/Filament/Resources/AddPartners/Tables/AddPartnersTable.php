<?php

namespace App\Filament\Resources\AddPartners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class AddPartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Partner by')
                    ->sortable(),
                TextColumn::make('contact.name')
                    ->label('Contact Person')
                    ->state(fn ($record) => $record->contacts()->first()?->name ?? 'N/A')
                    ->sortable()
                    ->searchable()
                    ->default('N/A'),
                TextColumn::make('contact.position')
                    ->label('Position')
                    ->state(fn ($record) => $record->contacts()->first()?->position ?? 'N/A')
                    ->sortable()
                    ->searchable()
                    ->default('N/A'),
                TextColumn::make('name')
                    ->label('Company Name')
                    ->searchable(),
                TextColumn::make('company_address')
                    ->label('Address')
                    ->icon('heroicon-o-map-pin')
                    ->state(fn ($record) => $record->contacts()->first()?->company_address ?? 'N/A')
                    ->copyable()
                    ->default('N/A')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
