<?php

namespace App\Filament\Resources\AddProducts\Schemas;

use Filament\Schemas\Schema;

class AddProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Infolists\Components\TextEntry::make('name')
                    ->label('Product Name'),
            ]);
    }
}
