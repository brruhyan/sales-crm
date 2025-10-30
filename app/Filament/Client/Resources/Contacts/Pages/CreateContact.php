<?php

namespace App\Filament\Client\Resources\Contacts\Pages;

use App\Filament\Client\Resources\Contacts\ContactResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
