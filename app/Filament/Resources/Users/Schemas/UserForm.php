<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->minLength(8)
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Section::make('Account Status')
                    ->schema([
                        Toggle::make('is_admin')
                            ->label('Admin User')
                            ->helperText('Admin users can access the admin panel')
                            ->default(false)
                            ->inline(false),
                        Toggle::make('approved')
                            ->label('Approved')
                            ->helperText('Users must be approved to access the client panel')
                            ->default(false)
                            ->inline(false),
                        DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->native(false),
                    ])
                    ->columns(2),
            ]);
    }
}
