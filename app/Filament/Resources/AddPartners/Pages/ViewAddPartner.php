<?php

namespace App\Filament\Resources\AddPartners\Pages;

use App\Filament\Resources\AddPartners\AddPartnerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAddPartner extends ViewRecord
{
    protected static string $resource = AddPartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
