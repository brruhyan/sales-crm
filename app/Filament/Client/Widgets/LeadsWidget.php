<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Leads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class LeadsWidget extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('New Leads', $this->visibleLeads()->whereIn('status', ['New', 'For Review'])->count()),
            Stat::make('Qualified Leads', $this->visibleLeads()->where('status', 'Qualified')->count()),
            Stat::make('Declined Leads', $this->visibleLeads()->whereIn('status', ['Declined', 'Lost'])->count()),
        ];
    }

    private function visibleLeads(): Builder
    {
        return Leads::query()->where(function (Builder $query): void {
            $query->whereNull('user_id');

            if (Auth::id() !== null) {
                $query->orWhere('user_id', Auth::id());
            }
        });
    }
}
