<?php

namespace App\Filament\Client\Resources\Leads\Pages;

use App\Filament\Client\Resources\Leads\LeadsResource;
use App\Models\Contact;
use Filament\Resources\Pages\CreateRecord;

class CreateLeads extends CreateRecord
{
    protected static string $resource = LeadsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Check if contact_id is not already set (meaning user didn't select an existing contact)
        if (empty($data['contact_id'])) {
            // Create a new contact with the lead's information
            $contact = Contact::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'company' => $data['company'] ?? null,
                'position' => null, // Lead doesn't have position field
            ]);

            // Set the contact_id for the lead
            $data['contact_id'] = $contact->id;
        }

        return $data;
    }
}
