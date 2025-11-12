<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Client\Widgets\State;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DealsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();
        
        return [
            Stat::make('Open Deals', Deal::where('user_id', $userId)->where('status', 'Open')->count()),
            Stat::make('Deals Won', Deal::where('user_id', $userId)->where('status', 'Deal Won')->count()),
            Stat::make(
                'Total Deal Value',
                Str::limit(
                    '₱' . number_format(Deal::where('user_id', $userId)->where('status', 'Deal Won')->sum('amount')),
                    50
                )), 
            Stat::make(
                'Pending Deal Value',
                Str::limit(
                    '₱' . number_format(Deal::where('user_id', $userId)->where('status', '!=', 'Deal Won')->sum('amount')),
                    50
                )), 
        ];
    }
}
