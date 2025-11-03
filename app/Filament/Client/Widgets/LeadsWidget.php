<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Leads;

class LeadsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Leads', Leads::where('status', 'New')->count()),
            Stat::make('Qualified Leads', Leads::where('status', 'Qualified')->count()),
            Stat::make('Lost Leads', Leads::where('status', 'Lost')->count()),
        ];
    }
}
