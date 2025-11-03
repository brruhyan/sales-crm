<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Project;

class ProjectsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Notice to Proceed', Project::where('status', 'Notice to Proceed')->count()),
            Stat::make('Ongoing', Project::where('status', 'Ongoing')->count()),
            Stat::make('Completed', Project::where('status', 'Completed')->count()),
        ];
    }
}
