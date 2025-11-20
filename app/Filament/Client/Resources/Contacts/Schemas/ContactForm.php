<?php

namespace App\Filament\Client\Resources\Contacts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Validation\Rule;
use Filament\Forms\Components\Select;
use App\Rules\ContactDuplicateChecker;
use Filament\Schemas\Components\Utilities\Get;
use App\Models\Partner;
use Illuminate\Support\Facades\Auth;

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
                    ->description('Company and position information of contact')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('position')
                            ->label('Position')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        Select::make('company')
                            ->label('Company/Partner')
                            ->options(function () {
                                if (Auth::check()) {
                                    return Auth::user()->partners()->pluck('name', 'id')->toArray();
                                }
                                return [];
                            })
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Partner Name')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->createOptionUsing(function (array $data) {
                                if (Auth::check()) {
                                    $partner = Partner::create([
                                        'name' => $data['name'],
                                        'user_id' => Auth::id(),
                                    ]);
                                    return $partner->id;
                                }
                                return null;
                            })
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('company_address')
                            ->label('Company Address')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                    ]),
            ]);
    }
}