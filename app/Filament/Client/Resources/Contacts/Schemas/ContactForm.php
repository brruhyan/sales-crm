<?php

namespace App\Filament\Client\Resources\Contacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Details')
                    ->description('Contact personal information')
                    ->columns(6)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->columnSpan(2)
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->columnSpan(2)
                            ->required(),
                        TextInput::make('phone')
                            ->label('Phone')
                            ->columnSpan(2)
                            ->tel()
                            ->required(),
                    ]),

                Section::make('Company Details')
                    ->description('Company and position information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('company')
                            ->label('Company')
                            ->required(),
                        TextInput::make('position')
                            ->label('Position')
                            ->required(),
                    ]),
            ]);
    }
}
