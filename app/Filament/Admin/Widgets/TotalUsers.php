<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use Illuminate\Support\Str;

class TotalUsers extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Approved Users', User::where('approved', '1')->count()),
            Stat::make('Pending Users', User::where('approved', '0')->count()),
            Stat::make('Top Performer', function (): string {
                $topUser = User::where('approved', '1')
                    ->withSum(['deals as deals_won_value' => function ($query) {
                        $query->where('status', 'Deal Won');
                    }], 'amount')
                    ->orderByDesc('deals_won_value')
                    ->limit(5)
                    ->first();

                return Str::limit($topUser ? $topUser->name : 'N/A', 10);
            }),
        ];
    }
}
