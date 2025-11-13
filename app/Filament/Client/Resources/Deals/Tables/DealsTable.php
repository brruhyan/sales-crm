<?php

namespace App\Filament\Client\Resources\Deals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DealsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Deal Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('contact.name')
                    ->label('Contact')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('contact.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('contact.phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('contact.company')
                    ->label('Company')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('amount')
                    ->label('Value')
                    ->money(fn ($record) => $record->currency ?? 'USD')
                    ->sortable(),
                
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'Prospecting' => 'gray',
                        'Deal Won' => 'success',
                        'Lost' => 'danger',
                        'For Review' => 'danger',
                        'Disputed' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('source')
                    ->label('Source')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('expected_close_date')
                    ->label('Expected Close')
                    ->date()
                    ->sortable(),

                TextColumn::make('actual_close_date')
                    ->label('Actual Close')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Prospecting' => 'Prospecting',
                        'Qualification' => 'Qualification',
                        'Needs Analysis' => 'Needs Analysis',
                        'Proposal' => 'Proposal',
                        'Negotiation' => 'Negotiation',
                        'Closed Won' => 'Closed Won',
                        'Closed Lost' => 'Closed Lost',
                    ])
                    ->multiple(),

                SelectFilter::make('source')
                    ->options([
                        'Inbound Lead' => 'Inbound Lead',
                        'Outbound' => 'Outbound',
                        'Referral' => 'Referral',
                        'Website' => 'Website',
                        'Social Media' => 'Social Media',
                        'Event' => 'Event',
                        'Partner' => 'Partner',
                        'Other' => 'Other',
                    ])
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
