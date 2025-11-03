<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Client\Widgets\State;
use App\Models\Deal;

class DealsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Open Deals', Deal::where('status', 'Prospecting')->count()),
            Stat::make('Won Deals', Deal::where('status', 'Closed Won')->count()),
            Stat::make('Lost Deals', Deal::where('status', 'Closed Lost')->count()),
            Stat::make('Total Deal Value', '₱' . number_format(Deal::sum('amount'))),
        ];
    }
}
