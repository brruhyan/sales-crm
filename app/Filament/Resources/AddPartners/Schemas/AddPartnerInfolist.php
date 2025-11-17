<?php

namespace App\Filament\Resources\AddPartners\Schemas;

use Filament\Schemas\Schema;

class AddPartnerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Infolists\Components\TextEntry::make('name')
                    ->label('Partner Name'),
            ]);
    }
}
