<?php

namespace App\Filament\Resources\AddPartners\Pages;

use App\Filament\Resources\AddPartners\AddPartnerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAddPartners extends ListRecords
{
    protected static string $resource = AddPartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
