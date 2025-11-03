<?php

namespace App\Filament\Client\Resources\Contacts\Pages;

use App\Filament\Client\Resources\Contacts\ContactResource;
use Filament\Actions\EditAction;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
