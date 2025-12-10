<?php

namespace App\Filament\Admin\Widgets;

use AlizHarb\ActivityLog\Widgets\ActivityChartWidget as BaseActivityChartWidget;

class ActivityChartWidget extends BaseActivityChartWidget
{
    public static function canView(): bool
    {
        return false;
    }
}
