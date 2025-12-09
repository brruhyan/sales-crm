<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use App\Models\Contact;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;
use App\Models\Leads;
use Illuminate\Validation\Rule;
use App\Rules\PartialMatchDuplicate;
use Filament\Forms\Components\FileUpload;
use App\Models\ProductList;
use App\Models\Partner;

class LeadsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead Contact Information')
                    ->description('Contact details for this lead')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('contact_id')
                            ->label('Select Existing Contact')
                            ->relationship('contact', 'name', fn($query) => $query->where('user_id', Auth::id()))
                            ->getOptionLabelFromRecordUsing(fn(Contact $record) => "{$record->name} - " . ($record->partner?->name ?? 'No company'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Select a contact to link to this lead.')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->label('Phone')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('position')
                                    ->label('Position')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('company')
                                    ->label('Company/Partner')
                                    ->helperText('Select existing or create new partner')
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
                                    ->required(),
                                TextInput::make('company_address')
                                    ->label('Company Address')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->createOptionUsing(function (array $data) {
                                if (Auth::check()) {
                                    $contact = Contact::create([
                                        'name' => $data['name'],
                                        'email' => $data['email'],
                                        'phone' => $data['phone'],
                                        'position' => $data['position'],
                                        'company' => $data['company'],
                                        'company_address' => $data['company_address'],
                                        'user_id' => Auth::id(),
                                    ]);
                                    return $contact->id;
                                }
                                return null;
                            }),
                    ]),

                Section::make('Product Lead Details')
                    ->description('Product details and specifications')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('lead_title')
                            ->label('Lead Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('lead_type')
                            ->label('Solution Type')
                            ->required()
                            ->options([
                                'Procurement' => 'Procurement',
                                'Implementation' => 'Implementation',
                                'Support' => 'Support',
                                'Consultation' => 'Consultation',
                                'System Integration' => 'System Integration',
                                'Other' => 'Other',
                            ])
                            ->columnSpan(1),
                        
                    

                        Select::make('product')
                            ->label('Project Inclusions & Services')
                            ->multiple()
                            ->required()
                            ->searchable()
                            ->preload()
                            ->options(ProductList::getOptions())
                            ->helperText('Select the product(s) this lead is interested in.')
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
                                'Warm' => 'Warm',
                                'Cold' => 'Cold',
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
