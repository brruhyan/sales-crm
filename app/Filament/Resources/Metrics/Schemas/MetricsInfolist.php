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
                        ->description('Deals won and its corresponding value.')
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
                Section::make()
                ->columnSpanFull()
                ->schema([
                    Section::make('Recent Deal Metrics')
                        ->columns(4)
                        ->description('Recent deals won and its corresponding value.')
                        ->schema([
                            TextEntry::make('recent_deal_won')
                                ->label('Most Recent Deal Won')
                                ->icon('heroicon-o-folder')
                                ->badge()
                                ->color('success')
                                ->columnSpan(2)
                                ->state(function ($record) {
                                    return Deal::where('user_id', $record->id) 
                                        ->where('status', 'Deal Won')
                                        ->latest()
                                        ->value('title') ?? '—';
                                })
                                ->columnSpanFull(),
                            TextEntry::make('recent_deal_value')
                                ->label('Most Recent Deal Value')
                                ->badge()
                                ->color('primary')
                                ->state(function ($record) {
                                    $totalValue = Deal::where('user_id', $record->id)
                                        ->where('status', 'Deal Won')
                                        ->latest()
                                        ->sum('amount');
                                    return '₱' . number_format($totalValue);
                                })
                        ]),
                ]),
            ]);
    }
}
