<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Client\Widgets\State;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class DealsWidget extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('New Deals', $this->visibleDeals()->whereIn('status', ['New', 'For Review'])->count()),
            Stat::make('Deals Won', $this->visibleDeals()->where('status', 'Deal Won')->count()),
            Stat::make(
                'Pending Deal Value',
                Str::limit(
                    '₱' . number_format($this->visibleDeals()->where('status', '!=', 'Deal Won')->sum('amount')),
                    50
                )), 
        ];
    }

    private function visibleDeals(): Builder
    {
        return Deal::query()->where(function (Builder $query): void {
            $query->whereNull('user_id');

            if (Auth::id() !== null) {
                $query->orWhere('user_id', Auth::id());
            }
        });
    }
}
