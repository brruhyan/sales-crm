<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Closing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class ClosingWidget extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('New Closings', $this->visibleClosings()->where('status', '!=', 'Closed Won')->count()),
            Stat::make('Closed Won', $this->visibleClosings()->where('status', 'Closed Won')->count()),
            Stat::make('Total Closed Value', '₱' . number_format($this->visibleClosings()->where('status', 'Closed Won')->sum('amount')))
        ];
    }

    private function visibleClosings(): Builder
    {
        return Closing::query()->where(function (Builder $query): void {
            $query->whereNull('user_id');

            if (Auth::id() !== null) {
                $query->orWhere('user_id', Auth::id());
            }
        });
    }
}
