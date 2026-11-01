<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DealsPerMonth extends ChartWidget
{
    protected ?string $heading = 'Deals Won Per Month';
    protected static ?int $sort = 2;
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

        $userId = $this->record->id ?? Auth::id();
        $driver = DB::connection()->getDriverName();
        $dateExpression = 'COALESCE(actual_close_date, updated_at)';
        $yearExpression = match ($driver) {
            'sqlite' => "strftime('%Y', {$dateExpression})",
            'pgsql' => "EXTRACT(YEAR FROM {$dateExpression})",
            default => "YEAR({$dateExpression})",
        };
        $monthExpression = match ($driver) {
            'sqlite' => "strftime('%m', {$dateExpression})",
            'pgsql' => "EXTRACT(MONTH FROM {$dateExpression})",
            default => "MONTH({$dateExpression})",
        };

        $dealsPerMonth = Deal::query()
            ->where('user_id', $userId)
            ->where('status', 'Deal Won')
            ->where(DB::raw($dateExpression), '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw("{$yearExpression} as year"),
                DB::raw("{$monthExpression} as month")
            )
            ->groupBy(DB::raw($yearExpression), DB::raw($monthExpression))
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            });

        $data = $months->map(function ($month) use ($dealsPerMonth) {
            $key = $month->format('Y-m');
            return $dealsPerMonth->get($key)?->count ?? 0;
        });

        return [
            'datasets' => [
                [
                    'label' => 'Deals Won',
                    'data' => $data->toArray(),
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
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
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
