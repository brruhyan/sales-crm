<?php

namespace App\Filament\Client\Resources\Deals\Pages;

use App\Filament\Client\Resources\Deals\DealResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeal extends EditRecord
{
    protected static string $resource = DealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
