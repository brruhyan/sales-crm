<?php

namespace App\Filament\Client\Resources\Projects\Pages;

use App\Filament\Client\Resources\Projects\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\ProjectsWidget;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProjectsWidget::class,
        ];
    }
}
