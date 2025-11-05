<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DealsValuePerMonth extends ChartWidget
{
    protected ?string $heading = 'Deals Value Per Month (Won)';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = [
             'md' => 1,
             'xl' => 1,
    ];

    protected function getData(): array
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i));
        }

        $dealsValuePerMonth = Deal::query()
            ->where('user_id', Auth::id())
            ->where('status', 'Deal Won')
            ->whereNotNull('actual_close_date')
            ->where('actual_close_date', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw('SUM(CASE WHEN currency = "PHP" THEN amount WHEN currency = "USD" THEN amount * 56 ELSE amount END) as total_value'),
                DB::raw('YEAR(actual_close_date) as year'),
                DB::raw('MONTH(actual_close_date) as month')
            )
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            });

        $data = $months->map(function ($month) use ($dealsValuePerMonth) {
            $key = $month->format('Y-m');
            return $dealsValuePerMonth->get($key)?->total_value ?? 0;
        });

        return [
            'datasets' => [
                [
                    'label' => 'Deal Value (PHP)',
                    'data' => $data->toArray(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->map(fn($month) => $month->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' =>[
                        'stepSize' => 50000,
                    ]
                ],
            ],
        ];
    }

}
