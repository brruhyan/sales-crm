<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        return [
            Stat::make('Notice to Proceed', Project::where('user_id', $userId)->where('status', 'Notice to Proceed')->count()),
            Stat::make('Ongoing', Project::where('user_id', $userId)->where('status', 'Ongoing')->count()),
            Stat::make('Completed', Project::where('user_id', $userId)->where('status', 'Completed')->count()),
        ];
    }
}
