<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use App\Models\Leads;

class LeadsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->label('Name'),
                TextEntry::make('email')->label('Email'),
                TextEntry::make('phone')->label('Phone'),
                TextEntry::make('company')->label('Company'),
                TextEntry::make('source')->label('Source'),
                TextEntry::make('status')->label('Status'),
            ]);
    }
}
