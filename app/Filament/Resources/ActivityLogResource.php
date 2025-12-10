<?php

namespace App\Filament\Resources;

use AlizHarb\ActivityLog\Resources\ActivityLogs\ActivityLogResource as BaseActivityLogResource;

class ActivityLogResource extends BaseActivityLogResource
{
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
