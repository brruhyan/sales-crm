<?php

namespace App\Filament\Resources\LeadTrackings\Pages;

use App\Filament\Resources\LeadTrackings\LeadTrackingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLeadTrackings extends ListRecords
{
    protected static string $resource = LeadTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
