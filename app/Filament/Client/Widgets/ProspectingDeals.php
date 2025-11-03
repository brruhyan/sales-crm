<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Deal;

class ProspectingDeals extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Prospecting Deals', Deal::where('status', 'Prospecting')->count()),
            Stat::make('Qualification Deals', Deal::where('status', 'Qualification')->count()),
            Stat::make('Proposals', Deal::where('status', 'Proposal')->count()),
            Stat::make('Won Deals', Deal::where('status', 'Closed Won')->count()),
        ];
    }
}
