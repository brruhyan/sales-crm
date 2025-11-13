<?php

namespace App\Filament\Imports;

use App\Models\Contact;
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
