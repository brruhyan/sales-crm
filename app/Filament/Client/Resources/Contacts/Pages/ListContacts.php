<?php

namespace App\Filament\Client\Resources\Contacts\Pages;

use App\Filament\Client\Resources\Contacts\ContactResource;
use App\Filament\Imports\ContactImporter;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Contact'),
            ImportAction::make()
                ->importer(ContactImporter::class)
                ->label('Import Contacts'),
        ];
    }
}
