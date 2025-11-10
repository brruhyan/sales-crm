<?php

namespace App\Filament\Client\Resources\Deals\Schemas;

use App\Models\Contact;
use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Get;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use App\Models\Leads;
use App\Rules\PartialMatchDuplicateDeal;

class DealForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Deal Information')
                    ->description('Basic deal details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label('Deal Title')
                            ->unique(ignoreRecord: true)
                            ->rules([new PartialMatchDuplicateDeal()])
                            ->helperText('Select Associated Lead to auto-fill this field.')
                            ->validationMessages([  
                                'unique' => 'This deal has already been added/taken.',
                            ])
                            ->required()
                            ->columnSpanFull(),
                        Select::make('source')
                            ->label('Associated Lead')
                            ->required()    
                            ->searchable()
                            ->relationship(
                                'lead',
                                'lead_title',
                                fn($query) => $query
                                    ->where('status', 'Qualified')
                                    ->where('user_id', Auth::id())
                            )
                            ->helperText('A lead must be of "qualified" status to be associated with a deal.')
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (?string $state, callable $set) {
                                if ($state) {
                                    $lead = Leads::find($state);
                                    if ($lead) {
                                        $set('title', 'Implementation of ' . $lead->lead_title ?? '');
                                    }
                                } else {
                                    $set('title', '');
                                }
                            })
                            ->columnSpan(1),
                        
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Open' => 'Open',
                                'Deal Won' => 'Deal Won',
                                'Lost' => 'Lost',
                            ])
                            ->default('Open')
                            ->required()
                            ->live()
                            ->columnSpan(1),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),

                    ]),
                Section::make('Associations')
                    ->description('Contact and associated lead')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('contact_id')
                            ->label('Contact')
                            ->required()
                            ->relationship('contact', 'name', fn($query) => $query->where('user_id', Auth::id()))
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->tel(),
                        TextInput::make('company'),
                        TextInput::make('position'),
                            ])
                            ->columnSpan(1),

                        Select::make('user_id')
                            ->label('Assigned To')
                            ->disabled()
                            ->columnSpan(2)
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->default(fn () => Auth::id())
                            ->preload()
                            ->columnSpan(1),
                    ]),


                Section::make('Financial Details')
                    ->description('Deal value and financial information')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('amount')
                            ->label('Deal Value')
                            ->numeric()
                            ->prefix('₱')
                            ->default(0)
                            ->required()
                            ->columnSpan(1),
                        
                        Select::make('currency')
                            ->label('Currency')
                            ->options([
                                'USD' => 'USD ($)',
                                'PHP' => 'PHP (₱)',
                            ])
                            ->default('PHP')
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('probability')
                            ->label('Win Probability (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->default(0)
                            ->required()
                            ->columnSpan(1),
                    ]),

            
                Section::make('Timeline')
                    ->description('Deal timeline and important dates')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        DatePicker::make('expected_close_date')
                            ->label('Expected Close Date')
                            ->required()
                            ->native(false)
                            ->columnSpan(1),

                        DatePicker::make('actual_close_date')
                            ->label('Actual Close Date')
                            ->required()
                            ->native(false)
                            ->columnSpan(1),
                    ]),
                Section::make('Supporting Documents')
                    ->description('Upload supporting documents and receipts for this deal.')
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
