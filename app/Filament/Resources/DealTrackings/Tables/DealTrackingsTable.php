<?php

namespace App\Filament\Resources\DealTrackings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use App\Models\Deal;
use Filament\Tables\Columns\TextColumn;
use App\Models\Leads;
use App\Models\User;

class DealTrackingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(Deal::query()->where('status', 'Deal Won'))
            ->columns([
                TextColumn::make('user.name')
                    ->label('Deal by')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Deal Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Deal Amount')
                    ->formatStateUsing(fn ($state) => '₱' . number_format($state, 0))
                    ->searchable()
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Deal Status')
                    ->badge()
                    ->color(function ($state) {
                        return match (strtolower($state)) {
                            'deal won' => 'success',
                            'lost' => 'danger',      
                            'open' => 'secondary',    
                            'proposal sent' => 'primary',  
                            default => 'secondary', // fallback color
                        };
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }
}
