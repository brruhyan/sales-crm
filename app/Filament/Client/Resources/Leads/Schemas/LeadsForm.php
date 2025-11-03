<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use App\Models\Contact;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;

class LeadsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead Details')
                    ->description('Lead and Company Information')
                    ->columns(4)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('contact_id')
                            ->label('Select Existing Contact (Optional)')
                            ->relationship('contact', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (?string $state, callable $set) {
                                if ($state) {
                                    $contact = Contact::find($state);
                                    if ($contact) {
                                        $set('name', $contact->name ?? '');
                                        $set('email', $contact->email ?? '');
                                        $set('phone', $contact->phone ?? '');
                                        $set('company', $contact->company ?? '');
                                    }
                                } else {
                                    $set('name', '');
                                    $set('email', '');
                                    $set('phone', '');
                                    $set('company', '');
                                }
                            })
                            ->columnSpanFull()
                            ->helperText('Select a contact to autofill the fields below, or leave empty to create a new lead'),

                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->live(onBlur: true)
                            ->columnSpan(1),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->columnSpan(1),
                        
                        TextInput::make('company')
                            ->label('Company')
                            ->columnSpan(1),
                        
                        TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->columnSpan(1),
                    ]),
                    
                Section::make('Lead Status')
                    ->description('Source and Status')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('source')
                            ->label('Source')
                            ->options([
                                'Website' => 'Website',
                                'Referral' => 'Referral',
                                'Social Media' => 'Social Media',
                                'Event' => 'Event',
                                'Cold Call' => 'Cold Call',
                                'Other' => 'Other',
                            ])
                            ->columnSpan(1),
                        
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'New' => 'New',
                                'Contacted' => 'Contacted',
                                'Qualified' => 'Qualified',
                                'Lost' => 'Lost',
                            ])
                            ->default('Contacted')
                            ->required()
                            ->columnSpan(1),
                    ]),
            ]);
    }
}