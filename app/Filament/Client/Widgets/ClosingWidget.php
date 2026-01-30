<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Closing;


class ClosingWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Closings', Closing::where('status', '!=', 'Closed Won')->count()),
            Stat::make('Closed Won', Closing::where('status', 'Closed Won')->count()),
            Stat::make('Total Closed Value', '₱' . number_format(Closing::where('status', 'Closed Won')->sum('amount')))
        ];
    }
}
