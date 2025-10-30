<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\ChartWidget;

class LeadsWidget extends ChartWidget
{
    protected ?string $heading = 'Leads by Status';

    protected function getData(): array
    {
        $statuses = ['New', 'Contacted', 'Qualified', 'Lost'];
        $counts = [];
        foreach ($statuses as $status) {
            $counts[$status] = \App\Models\Leads::where('status', $status)->count();
        }
        return [
            'labels' => array_keys($counts),
            'datasets' => [
                [
                    'label' => 'Leads by Status',
                    'data' => array_values($counts),
                    'backgroundColor' => [
                        '#3b82f6', // New
                        '#f59e42', // Contacted
                        '#10b981', // Qualified
                        '#ef4444', // Lost
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
