<?php

namespace App\Filament\Client\Resources\Contacts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Personal Details')
                    ->description('Contact personal information')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('John Doe')
                            ->columnSpan(1),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('john.doe@example.com')
                            ->unique(ignoreRecord: true)
                            ->columnSpan(1),

                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('09123456789')
                            ->columnSpan(1),
                    ]),

                Section::make('Company Details')
                    ->description('Company and position information')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('company')
                            ->label('Company Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Acme Corporation')
                            ->columnSpan(1),

                        TextInput::make('position')
                            ->label('Job Position')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Sales Manager')
                            ->columnSpan(1),
                    ]),
            ]);
    }
}