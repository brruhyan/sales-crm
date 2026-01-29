<?php

namespace App\Filament\Resources\ClosingTrackings\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class ClosingTrackingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Closing by')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deal.title')
                    ->label('Associated Deal')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(function ($state) {
                        return match ($state) {
                            'Open' => 'primary',
                            'In Progress' => 'info',
                            'Pending Review' => 'warning',
                            'Closed Won' => 'success',
                            'Closed Lost' => 'danger',
                            default => 'secondary',
                        };
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state, 2))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact.name')
                    ->label('Contact')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y H:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->label('Filter by User')
                    ->relationship('user', 'name')
                    ->multiple()
                    ->preload(),
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        'Open' => 'Open',
                        'In Progress' => 'In Progress',
                        'Pending Review' => 'Pending Review',
                        'Closed Won' => 'Closed Won',
                        'Closed Lost' => 'Closed Lost',
                    ])
                    ->multiple(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
