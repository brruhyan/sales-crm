<?php

namespace App\Filament\Client\Resources\Projects\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Project Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-folder-open'),

                TextColumn::make('deal.title')
                    ->label('Associated Deal')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-currency-dollar'),

                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'Notice to Proceed' => 'info',
                        'Ongoing' => 'warning',
                        'Finished' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('budget')
                    ->label('Budget')
                    ->money('PHP')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Notice to Proceed' => 'Notice to Proceed',
                        'Ongoing' => 'Ongoing',
                        'Finished' => 'Finished',
                    ])
                    ->multiple(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
