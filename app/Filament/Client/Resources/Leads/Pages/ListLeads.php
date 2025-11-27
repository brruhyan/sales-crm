<?php

namespace App\Filament\Client\Resources\Leads\Pages;

use App\Filament\Client\Resources\Leads\LeadsResource;
use Filament\Actions\CreateAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Client\Widgets\LeadsWidget;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use App\Filament\Exports\LeadsExporter;
use App\Filament\Imports\LeadsImporter;

class ListLeads extends ListRecords
    {
        protected static string $resource = LeadsResource::class;

    protected function getHeaderActions(): array
    {
        return [    
            CreateAction::make()
                ->label('Add Lead'),
            ExportAction::make()
                ->exporter(LeadsExporter::class)
                ->label('Export Leads'),
            ImportAction::make()
                ->importer(LeadsImporter::class)
                ->label('Import Leads'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            LeadsWidget::class,
        ];
    }
}
