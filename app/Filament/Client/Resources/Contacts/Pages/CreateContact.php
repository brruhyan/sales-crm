<?php

namespace App\Filament\Client\Resources\Contacts\Pages;

use App\Filament\Client\Resources\Contacts\ContactResource;
use App\Models\Contact;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $warnings = [];

        $sameNameAndEmailOtherUser = Contact::where('name', $this->record->name)
            ->where('email', $this->record->email)
            ->where('user_id', '!=', Auth::id())
            ->first();

        if ($sameNameAndEmailOtherUser) {
            Notification::make()
                ->title('Contact Registered by Another User')
                ->body("Another user has already registered '{$this->record->name}' with email '{$this->record->email}'. Please verify this is not a duplicate.")
                ->warning()
                ->send();
            return;
        }

        $sameNameDifferentEmailCurrentUser = Contact::where('name', $this->record->name)
            ->where('email', '!=', $this->record->email)
            ->where('user_id', Auth::id())
            ->first();

        if ($sameNameDifferentEmailCurrentUser) {
            Notification::make()
                ->title('Contact Already Exists with Different Email')
                ->body("You already have '{$this->record->name}' registered with email '{$sameNameDifferentEmailCurrentUser->email}'. Ignore if contact has multiple emails.")
                ->warning()
                ->send();
        }
    }
}
