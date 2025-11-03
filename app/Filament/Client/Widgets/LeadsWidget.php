<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Leads;
use Illuminate\Support\Facades\Auth;

class LeadsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();
        
        return [
            Stat::make('New Leads', Leads::where('user_id', $userId)->where('status', 'New')->count()),
            Stat::make('Qualified Leads', Leads::where('user_id', $userId)->where('status', 'Qualified')->count()),
            Stat::make('Lost Leads', Leads::where('user_id', $userId)->where('status', 'Lost')->count()),
        ];
    }
}
