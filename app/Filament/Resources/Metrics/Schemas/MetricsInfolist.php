<?php

namespace App\Filament\Resources\Metrics\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Models\Deal;
use App\Models\Leads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MetricsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        $userId = Auth::id();

        return $schema
            ->components([
                Section::make()
                ->columnSpanFull()
                ->schema([
                    Section::make('Metrics Details')
                        ->columns(3)
                        ->schema([
                            TextEntry::make('name')
                                ->label('Name')
                                ->columnSpan(1)
                                ->icon('heroicon-o-tag'),
                            TextEntry::make('Total Deals')
                                ->label('Deals Won')
                                ->state(function (User $record): string {
                                    return (string) Deal::where('user_id', $record->id)
                                        ->where('status', 'Deal Won')
                                        ->count();
                                })
                                ->badge()
                                ->color('primary')
                                ->columnSpan(1),
                            TextEntry::make('Total Deal Value')
                                ->label('Total Deal Value')
                                ->badge()
                                ->state(function (User $record): string {
                                    $totalValue = Deal::where('user_id', $record->id)
                                        ->where('status', 'Deal Won')
                                        ->sum('amount');
                                    return '₱' . number_format($totalValue);
                                })
                                ->color('warning')
                        ]),
                ]),
            ]);
    }
}
