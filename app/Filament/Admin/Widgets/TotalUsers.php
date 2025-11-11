<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class TotalUsers extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Approved Users', User::where('approved', '1')->count()),
            Stat::make('Pending Users', User::where('approved', '0')->count()),
        ];
    }
}
