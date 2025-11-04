<?php

namespace App\Filament\Client\Resources\Leads\Pages;

use App\Filament\Client\Resources\Leads\LeadsResource;
use Filament\Actions\EditAction;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Client\Actions\MarkLeadQualifiedAction;
use App\Filament\Client\Actions\MarkLeadLostAction;
use App\Filament\Client\Widgets\LeadsWidget;

class ViewLeads extends ViewRecord
{
    protected static string $resource = LeadsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            MarkLeadQualifiedAction::make(),
            MarkLeadLostAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
