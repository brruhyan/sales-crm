<?php

namespace App\Filament\Exports;

use App\Models\Deals;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class DealsExporter extends Exporter
{
    protected static ?string $model = Deals::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('title')
                ->label('Deal Title'),
            ExportColumn::make('description')
                ->label('Description'),
            ExportColumn::make('amount')
                ->label('Amount'),
            ExportColumn::make('currency')
                ->label('Currency'),
            ExportColumn::make('probability')
                ->label('Probability (%)'),
            ExportColumn::make('status')
                ->label('Status'),
            ExportColumn::make('source')
                ->label('Source'),
            ExportColumn::make('expected_close_date')
                ->label('Expected Close Date'),
            ExportColumn::make('actual_close_date')
                ->label('Actual Close Date'),
            ExportColumn::make('contact.name')
                ->label('Contact Name'),
            ExportColumn::make('contact.email')
                ->label('Contact Email'),
            ExportColumn::make('contact.phone')
                ->label('Contact Phone'),
            ExportColumn::make('contact.company')
                ->label('Company'),
            ExportColumn::make('user.name')
                ->label('Assigned To'),
            ExportColumn::make('lead.lead_title')
                ->label('Associated Lead'),
            ExportColumn::make('created_at')
                ->label('Created At'),
            ExportColumn::make('updated_at')
                ->label('Updated At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your deals export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
