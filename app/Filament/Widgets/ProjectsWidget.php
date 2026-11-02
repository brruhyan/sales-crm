<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ProjectsWidget extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('Notice to Proceed', $this->visibleProjects()->where('status', 'Notice to Proceed')->count()),
            Stat::make('Ongoing', $this->visibleProjects()->where('status', 'Ongoing')->count()),
            Stat::make('Completed', $this->visibleProjects()->where('status', 'Completed')->count()),
        ];
    }

    private function visibleProjects(): Builder
    {
        return Project::query()->where(function (Builder $query): void {
            $query->whereNull('user_id');

            if (Auth::id() !== null) {
                $query->orWhere('user_id', Auth::id());
            }
        });
    }
}
