<?php

namespace App\Filament\Admin\Widgets;

use AlizHarb\ActivityLog\Widgets\LatestActivityWidget as BaseLatestActivityWidget;

class LatestActivityWidget extends BaseLatestActivityWidget
{
    public static function canView(): bool
    {
        return false;
    }
}
