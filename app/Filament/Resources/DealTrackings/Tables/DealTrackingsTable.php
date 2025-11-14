<?php

namespace App\Filament\Resources\DealTrackings\Tables;

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

class DealTrackingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Deal by')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Deal Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Deal Status')
                    ->badge()
                    ->color(function ($state) {
                        return match (strtolower($state)) {
                            'for review' => 'warning',
                            'deal won' => 'success',
                            'lost' => 'danger',      
                            'open' => 'secondary',    
                            'proposal sent' => 'primary',
                            'For Review' => 'danger',
                            'Disputed' => 'danger',  
                            default => 'secondary', 
                        };
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Deal Amount')
                    ->formatStateUsing(fn ($state) => '₱' . number_format($state, 0))
                    ->searchable()
                    ->badge()
                    ->color('primary')
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
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        'Open' => 'Open',
                        'Proposal Sent' => 'Proposal Sent',
                        'Deal Won' => 'Deal Won',
                        'Lost' => 'Lost',
                    ]),
                SelectFilter::make('company')
                    ->label('Filter by Company')
                    ->relationship('contact', 'company')
                    ->multiple()
                    ->preload(),
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
