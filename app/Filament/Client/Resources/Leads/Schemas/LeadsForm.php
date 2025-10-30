<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class LeadsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead Details')
                    ->description('Lead and Company Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')->label('Name'),
                        TextInput::make('email')->label('Email'),
                        TextInput::make('company')->label('Company'),
                        TextInput::make('phone')->label('Phone'),
                    ]),
                Section::make('Lead Status')
                    ->description('Source and Status')
                    ->columns(2)
                    ->schema([
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
                    ]),
      
            ]);
    }
}
