<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Client\Widgets\State;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;

class DealsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();
        
        return [
            Stat::make('Open Deals', Deal::where('user_id', $userId)->where('status', 'Prospecting')->count()),
            Stat::make('Deals Won', Deal::where('user_id', $userId)->where('status', 'Closed Won')->count()),
            Stat::make('Lost Deals', Deal::where('user_id', $userId)->where('status', 'Closed Lost')->count()),
            Stat::make('Total Deal Value', '₱' . number_format(Deal::where('user_id', $userId)->where('status', 'Closed Won')->sum('amount'))),
        ];
    }
}
