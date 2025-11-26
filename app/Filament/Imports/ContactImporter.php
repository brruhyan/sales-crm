<?php

namespace App\Filament\Imports;

use App\Models\Contact;
use App\Models\Partner;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class ContactImporter extends Importer
{
    protected static ?string $model = Contact::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('Name')
                ->example('John Doe')
                ->requiredMapping(),
            ImportColumn::make('company')
                ->example('Acme Corp')
                ->label('Company'),
            ImportColumn::make('company_address')
                ->example('123 Main St, City, Country')
                ->label('Company Address'),
            ImportColumn::make('email')
                ->label('Email')
                ->example('john.doe@example.com'),
            ImportColumn::make('phone')
                ->label('Phone')
                ->example('(123) 456-7890'),
            ImportColumn::make('position')
                ->label('Position')
                ->example('Sales Manager'),
        ];
    }

    public function resolveRecord(): Contact
    {
        return Contact::firstOrNew([
            'name' => $this->data['name'],
            'user_id' => Auth::id(),
        ]);
    }

    protected function beforeSave(): void
    {
        // Ensure the user_id is set to the current authenticated user
        $this->record->user_id = Auth::id();

        // Handle company/partner auto-creation
        if (!empty($this->data['company'])) {
            $companyName = $this->data['company'];
            
            // Check if partner already exists for this user with the same name
            $partner = Partner::where('name', $companyName)
                ->where('user_id', Auth::id())
                ->first();
            
            // If it doesn't exist, create it
            if (!$partner) {
                $partner = Partner::create([
                    'name' => $companyName,
                    'user_id' => Auth::id(),
                ]);
            }
            
            // Assign the partner ID to the contact's company field
            $this->record->company = $partner->id;
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your contact import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

