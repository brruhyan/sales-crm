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

        // If contact_id is selected, get the contact data
        if (!empty($data['contact_id'])) {
            $contact = Contact::find($data['contact_id']);
            if ($contact) {
                $data['name'] = $contact->name;
                $data['email'] = $contact->email;
                $data['phone'] = $contact->phone;
                $data['company'] = $contact->company;
                $data['company_address'] = $contact->company_address ?? null;
            }
        } else {
            // Create a new contact if one wasn't selected
            $contact = Contact::create([
                'user_id' => Auth::id(),
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'company' => $data['company'] ?? null,
                'position' => null,
            ]);

            $data['contact_id'] = $contact->id;
        }

        return $data;
    }
}
