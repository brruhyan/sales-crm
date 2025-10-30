<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class LeadsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required(),
                TextInput::make('company')
                    ->label('Company')
                    ->nullable(),
                Select::make('source')
                    ->label('Source')
                    ->options([
                        'Website' => 'Website',
                        'Referral' => 'Referral',
                        'Social Media' => 'Social Media',
                        'Other' => 'Other',
                    ]),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'New' => 'New',
                        'Contacted' => 'Contacted',
                        'Qualified' => 'Qualified',
                        'Lost' => 'Lost',
                    ])
                    ->default('New')
                    ->required(),
            ]);
    }
}
