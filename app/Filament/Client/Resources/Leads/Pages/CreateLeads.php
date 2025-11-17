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
        $data['user_id'] = Auth::id();

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

    protected function afterCreate(): void
    {
        $leadTitle = $this->record->lead_title ?? '';
        $leadId = $this->record->id ?? null;
        
        $partialMatch = app(\App\Rules\PartialMatchDuplicate::class)->checkPartialMatch($leadTitle, $leadId);
        if ($partialMatch) {
            \Filament\Notifications\Notification::make()
                ->title('Warning: Similar lead detected')
                ->body('Another user has already registered a similar lead. Proceed with caution.')
                ->warning()
                ->send();
        }
    }
}
