<?php

namespace App\Filament\Resources\LeadTrackings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Deal;
use App\Models\Leads;
use App\Models\User;

class LeadTrackingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Lead by')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lead_title')
                    ->label('Lead Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Lead Status')
                    ->badge()
                    ->color(function ($state) {
                        return match (strtolower($state)) {
                            'for review' => 'danger',
                            'new' => 'primary',
                            'contacted' => 'secondary',
                            'qualified' => 'success',
                            'disputed' => 'danger',
                            'lost' => 'danger',
                            default => 'secondary',
                        };
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y H:i A')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y H:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->label('Filter by User')
                    ->relationship('user', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
