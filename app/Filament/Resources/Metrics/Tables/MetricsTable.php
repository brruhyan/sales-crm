<?php

namespace App\Filament\Resources\Metrics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Deal;
use App\Models\Leads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MetricsTable
{
    public static function configure(Table $table): Table
    {

    $userId = Auth::id();

        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->copyable(),
                TextColumn::make('qualified_leads_count')
                    ->label('Qualified Leads')
                ->state(function (User $record): string {
                    return (string) Leads::where('user_id', $record->id)
                        ->where('status', 'Qualified')
                        ->count();
                })
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('Total Deals')
                    ->label('Deals Won')
                    ->state(function (User $record): string {
                        return (string) Deal::where('user_id', $record->id)
                            ->where('status', 'Deal Won')
                            ->count();
                    })
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('Total Deal Value')
                    ->label('Total Deal Value')
                    ->badge()
                    ->state(function (User $record): string {
                        $totalValue = Deal::where('user_id', $record->id)
                            ->where('status', 'Deal Won')
                            ->sum('amount');
                        return '₱' . number_format($totalValue);
                    })
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('Pending Deal Value')
                    ->label('Pending Deal Value')
                    ->badge()
                    ->state(function (User $record): string {
                        $totalValue = Deal::where('user_id', $record->id)
                            ->where('status', '!=', 'Deal Won')
                            ->sum('amount');
                        return '₱' . number_format($totalValue);
                    })
                    ->color('warning')
            ])
            ->filters([
                
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
