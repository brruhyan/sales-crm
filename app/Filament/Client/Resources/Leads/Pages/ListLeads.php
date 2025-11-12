<?php

namespace App\Filament\Client\Resources\Leads\Pages;

use App\Filament\Client\Resources\Leads\LeadsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Client\Widgets\LeadsWidget;
use Filament\Actions\ExportAction;
use App\Filament\Exports\LeadsExporter;

class ListLeads extends ListRecords
    {
        protected static string $resource = LeadsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()
                ->exporter(LeadsExporter::class)
                ->label('Export Leads'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            LeadsWidget::class,
        ];
    }
}
