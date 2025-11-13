<?php

namespace App\Filament\Imports;

use App\Models\Leads;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class LeadsImporter extends Importer
{
    protected static ?string $model = Leads::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('lead_title')
                ->requiredMapping()
                ->example('New Lead Title')
                ->rules(['required', 'max:255']),
            ImportColumn::make('lead_type')
                ->example('Procurement')
                ->rules(['max:255']),
            ImportColumn::make('product')
                ->requiredMapping()
                ->example('Product Name')
                ->rules(['required', 'max:255']),
            ImportColumn::make('contact')
                ->example('Contact Name or ID')
                ->relationship(),
            ImportColumn::make('name')
                ->requiredMapping()
                ->example('John Doe')
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->example('test@gmail.com')
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('phone')
                ->requiredMapping()
                ->example('+1234567890')
                ->rules(['required', 'max:255']),
            ImportColumn::make('company')
                ->example('Company Name')
                ->rules(['max:255']),
            ImportColumn::make('source')
                ->example('Website')
                ->rules(['max:255']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->example('New')
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): Leads
    {
        return Leads::firstOrNew([
            'lead_title' => $this->data['lead_title'],
        ]);
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
