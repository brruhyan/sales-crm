<?php

namespace App\Filament\Client\Resources\Leads\Pages;

use App\Filament\Client\Resources\Leads\LeadsResource;
use App\Models\Contact;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateLeads extends CreateRecord
{
    protected static string $resource = LeadsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set the user_id to the authenticated user
        $data['user_id'] = Auth::id();

        // Get the contact data to populate lead fields
        if (!empty($data['contact_id'])) {
            $contact = Contact::find($data['contact_id']);
            if ($contact) {
                $data['name'] = $contact->name;
                $data['email'] = $contact->email;
                $data['phone'] = $contact->phone;
                $data['company'] = $contact->company;
            }
        }

        return $data;
    }
}
