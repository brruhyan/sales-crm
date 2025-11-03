<?php

namespace App\Filament\Client\Resources\Leads\Pages;

use App\Filament\Client\Resources\Leads\LeadsResource;
use Filament\Actions\EditAction;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLeads extends ViewRecord
{
    protected static string $resource = LeadsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
