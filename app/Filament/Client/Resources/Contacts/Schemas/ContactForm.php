<?php

namespace App\Filament\Client\Resources\Contacts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Validation\Rule;
use Filament\Forms\Components\Select;
use App\Rules\ContactDuplicateChecker;
use Filament\Schemas\Components\Utilities\Get;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Details')
                    ->description('Contact personal information')
                    ->columns(4)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                    ]),

                Section::make('Company Details')
                    ->description('Company and position information')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('position')
                            ->label('Position')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        Select::make('company')
                            ->label('Company')
                            ->preload()
                            ->searchable()
                            ->options([
                                'TPB' => 'TPB',
                                'LCCAD' => 'LCCAD',
                                'Other' => 'Other',
                            ])
                            ->required()
                            ->columnSpan(1),
                    ]),
            ]);
    }
}