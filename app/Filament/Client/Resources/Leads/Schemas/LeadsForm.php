<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use App\Models\Contact;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;
use App\Models\Leads;
use Illuminate\Validation\Rule;
use App\Rules\PartialMatchDuplicate;

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
                        TextInput::make('lead_title')
                            ->label('Lead Title')
                            ->required()
                            ->rules([
                                new PartialMatchDuplicate(
                                    request()->route('record')?->id ?? null
                                ),
                            ])
                            ->validationMessages([
                                'unique' => 'This lead has already been added/taken.',
                            ])
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('contact_id')
                            ->label('Select Existing Contact (Optional)')
                            ->relationship('contact', 'name', fn($query) => $query->where('user_id', Auth::id()))
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
                            ->required()
                            ->columnSpan(1),
                        
                        TextInput::make('phone')
                            ->label('Phone')
                            ->required()
                            ->tel()
                            ->columnSpan(1),
                    ]),
                Section::make('Lead Type')
                    ->description('Lead Classification')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('industry')
                            ->label('Industry')
                            ->helperText('Select industry first before proceeding to Category')
                            ->required()
                            ->options([
                                'Technology' => 'Technology',
                                'Healthcare' => 'Healthcare',
                                'Finance' => 'Finance',
                                'Education' => 'Education',
                            ])
                            ->reactive()
                            ->afterStateUpdated(function (?string $state, callable $set) {
                                if ($state === 'Technology') {
                                    $set('lead_type', 'Tech Lead');
                                    $set('industry_type', 'Software');
                                } elseif ($state === 'Healthcare') {
                                    $set('lead_type', 'Health Lead');
                                    $set('industry_type', 'Hospital');
                                } elseif ($state === 'Finance') {
                                    $set('lead_type', 'Finance Lead');
                                    $set('industry_type', 'Banking');
                                } elseif ($state === 'Education') {
                                    $set('lead_type', 'Education Lead');
                                    $set('industry_type', 'School');
                                } else {
                                    $set('lead_type', 'General Lead');
                                    $set('industry_type', null);
                                }
                            })
                            ->columnSpan(1),
                        Select::make('category')
                            ->label('Category')
                            ->required()
                            ->options(function (callable $get) {
                                $industry = $get('industry');

                                return match ($industry) {
                                    'Technology' => [
                                        'Software' => 'Software',
                                        'Hardware' => 'Hardware',
                                        'AI' => 'AI',
                                    ],
                                    'Healthcare' => [
                                        'Hospital' => 'Hospital',
                                        'Pharmaceutical' => 'Pharmaceutical',
                                    ],
                                    'Finance' => [
                                        'Banking' => 'Banking',
                                        'Investment' => 'Investment',
                                    ],
                                    'Education' => [
                                        'School' => 'School',
                                        'University' => 'University',
                                    ],
                                    default => [],
                                };
                            })
                            ->columnSpan(1),
                    ]),
                    
                Section::make('Lead Status')
                    ->description('Source and Status')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('source')
                            ->label('Source')
                            ->required()
                            ->options([
                                'Website' => 'Website',
                                'Referral' => 'Referral',
                                'Event' => 'Event',
                                'Other' => 'Other',
                            ])
                            ->columnSpan(1),
                        
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'New' => 'New',
                                'Contacted' => 'Contacted',
                                'Qualified' => 'Qualified',
                                'Declined' => 'Declined',
                            ])
                            ->default('New')
                            ->required()
                            ->columnSpan(1),
                    ]),
            ]);
    }
}