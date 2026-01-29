<?php

namespace App\Filament\Resources;

use AlizHarb\ActivityLog\Resources\ActivityLogs\ActivityLogResource as BaseActivityLogResource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ActivityLogResource extends BaseActivityLogResource
{
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        $table = parent::table($table);

        // Customize the description column to not truncate
        $table->columns(
            collect($table->getColumns())
                ->map(function ($column) {
                    if ($column instanceof TextColumn && $column->getName() === 'description') {
                        return $column
                            ->limit(null)
                            ->wrap();
                    }
                    return $column;
                })
                ->toArray()
        );

        return $table;
    }
}
