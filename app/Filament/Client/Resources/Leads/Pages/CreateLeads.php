<?php

namespace App\Filament\Client\Resources\Leads\Pages;

use App\Filament\Client\Resources\Leads\LeadsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLeads extends CreateRecord
{
    protected static string $resource = LeadsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['lead_by'] = auth()->user()->name;
        return $data;
    }
}
