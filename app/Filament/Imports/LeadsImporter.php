<?php

namespace App\Filament\Imports;

use App\Models\Leads;
use App\Models\Contact;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class LeadsImporter extends Importer
{
    protected static ?string $model = Leads::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('lead_title')
                ->label('Lead Title')
                ->requiredMapping()
                ->example('New Lead Title')
                ->rules(['required', 'max:255']),
            ImportColumn::make('lead_type')
                ->label('Solution Type')
                ->example('Procurement')
                ->rules(['max:255']),
            ImportColumn::make('product')
                ->label('Products')
                ->requiredMapping()
                ->example('Product Name 1, Product Name 2')
                ->rules(['required']),
            ImportColumn::make('contact_name')
                ->label('Contact Name')
                ->example('Contact Name')
                ->rules(['max:255']),
            ImportColumn::make('name')
                ->label('Lead Name')
                ->requiredMapping()
                ->example('John Doe')
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->label('Email')
                ->requiredMapping()
                ->example('test@gmail.com')
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('phone')
                ->label('Phone')
                ->requiredMapping()
                ->example('+1234567890')
                ->rules(['required', 'max:255']),
            ImportColumn::make('company')
                ->label('Company')
                ->example('Company Name')
                ->rules(['max:255']),
            ImportColumn::make('source')
                ->label('Source')
                ->example('Website')
                ->rules(['max:255']),
            ImportColumn::make('status')
                ->label('Status')
                ->requiredMapping()
                ->example('New')
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): Leads
    {
        return Leads::firstOrNew([
            'lead_title' => $this->data['lead_title'],
            'user_id' => Auth::id(),
        ]);
    }

    protected function beforeSave(): void
    {
        // Set user_id to the authenticated user
        $this->record->user_id = Auth::id();

        // Handle contact lookup by name using contact_name field
        if (!empty($this->data['contact_name'])) {
            $contact = Contact::where('name', $this->data['contact_name'])
                ->where('user_id', Auth::id())
                ->first();
            
            if ($contact) {
                $this->record->contact_id = $contact->id;
            }
        }

        // Handle product as array (split by comma)
        if (!empty($this->data['product'])) {
            $products = array_map('trim', explode(',', $this->data['product']));
            $this->record->product = $products;
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your leads import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
