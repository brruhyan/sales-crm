<?php

namespace App\Filament\Resources\AddPartners\Pages;

use App\Filament\Resources\AddPartners\AddPartnerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAddPartner extends EditRecord
{
    protected static string $resource = AddPartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
