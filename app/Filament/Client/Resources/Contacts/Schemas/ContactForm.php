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
                            ->preload()
                            ->searchable()
                            ->options([
                                'Department of National Defense' => 'Department of National Defense',
                                'Department of Environment and Natural Resources' => 'Department of Environment and Natural Resources',
                                'Department of Energy' => 'Department of Energy',
                                'Philippine Ports Authority' => 'Philippine Ports Authority',
                                'National Commission on Indigenous Peoples' => 'National Commission on Indigenous Peoples',
                                'Department of Health' => 'Department of Health',
                                'Tourism Promotions Board' => 'Tourism Promotions Board',
                                'Construction Industry Authority of the Philippines' => 'Construction Industry Authority of the Philippines',
                                'City of Palawan' => 'City of Palawan',
                                'City of Alabat' => 'City of Alabat',
                                'City of Pasig' => 'City of Pasig',
                                'Other Government' => 'Other Government',
                                'Landbank Resources and Development Corp (LBRDC)' => 'Landbank Resources and Development Corp (LBRDC)',
                                'Pampanga State Agricultural University' => 'Pampanga State Agricultural University',
                                'CARD Bank Inc.' => 'CARD Bank Inc.',
                                'ASLA Savings and Loans Association' => 'ASLA Savings and Loans Association',
                                'Earth Island Institute' => 'Earth Island Institute',
                                'Digital Halo DC Phils Inc' => 'Digital Halo DC Phils Inc',
                                'iTelecast PH' => 'iTelecast PH',
                                'Others' => 'Others',
                            ])
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