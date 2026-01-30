<?php

namespace App\Filament\Client\Resources\Closings\Pages;

use App\Filament\Client\Resources\Closings\ClosingResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Actions\CreateAction;
use App\Filament\Client\Widgets\ClosingWidget;
    class ListClosings extends ListRecords
{
    protected static string $resource = ClosingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Closing')

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ClosingWidget::class,
        ];
    }
}
