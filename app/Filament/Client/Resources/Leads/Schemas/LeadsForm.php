<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use App\Models\Contact;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;
use App\Models\Leads;
use Illuminate\Validation\Rule;
use App\Rules\PartialMatchDuplicate;
use Filament\Forms\Components\FileUpload;

class LeadsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead Contact Information')
                    ->description('Contact details for this lead')
                    ->columns(4)
                    ->columnSpanFull()
                    ->schema([
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

                Section::make('Product Lead Details')
                    ->description('Product details and specifications')
                    ->columns(2)
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

                        Select::make('category')
                            ->label('Category')
                            ->required()
                            ->options([
                                'Business Operations' => 'Business Operations',
                                'Security' => 'Security',
                                'Smart Projects' => 'Smart Projects',
                                'Other' => 'Other',
                            ])
                            ->live()
                            ->columnSpan(1),

                        Select::make('product')
                            ->label('Product')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->options(function (Get $get) {
                                return match ($get('category')) {
                                    'Business Operations' => [
                                        'DataFusion 360' => 'DataFusion 360',
                                        'AksyonSentral' => 'AksyonSentral',
                                        'AksyonMap' => 'AksyonMap',
                                        'AksyonCare' => 'AksyonCare',
                                        'AksyonERP' => 'AksyonERP',
                                        'AksyonGov' => 'AksyonGov',
                                    ],
                                    'Security' => [
                                        'CWAT' => 'CWAT',
                                        'AksyonShield' => 'AksyonShield',
                                        'AksyonCrypt' => 'AksyonCrypt',
                                        'AksyonChain' => 'AksyonChain',
                                    ],
                                    'Smart Projects' => [
                                        'Smart City' => 'Smart City',
                                        'Smart Campus' => 'Smart Campus',
                                    ],
                                    'Other' => [
                                        'Others' => 'Others',
                                    ],
                                    default => [],
                                };
                            })
                            ->helperText('Select the product this lead is interested in.')
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
                            ])
                            ->default('New')
                            ->required()
                            ->columnSpan(1),
                    ]),

                Section::make('Supporting Documents')
                    ->description('Upload supporting documents and receipts for this lead.')
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('documents')
                            ->label('Documents')
                            ->required()
                            ->multiple()
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->disk('public')
                            ->directory('deal-documents')
                            ->visibility('public')
                            ->minFiles(0)
                            ->maxFiles(5)
                            ->downloadable()
                            ->openable()
                            ->previewable(true)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
