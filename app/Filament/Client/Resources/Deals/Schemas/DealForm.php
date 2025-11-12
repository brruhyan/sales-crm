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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use App\Models\Leads;
use App\Rules\PartialMatchDuplicateDeal;
use App\Rules\DealTitleMustContainLeadKeywords;
use Closure;

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
                            ->disabled()
                            ->dehydrated(true)
                            ->unique(ignoreRecord: true)
                            ->helperText('Auto-populated from the associated lead.')
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
                                        $leadType = $lead->lead_type ?? 'Implementation';
                                        $set('title', ucfirst($leadType) . ' of ' . $lead->lead_title ?? '');
                                        $set('contact_id', $lead->contact_id);
                                    }
                                } else {
                                    $set('title', '');
                                    $set('contact_id', null);
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
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Associations')
                    ->description('Contact and team member assignment')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('contact_id')
                            ->label('Contact')
                            ->disabled()
                            ->dehydrated(true)
                            ->relationship('contact', 'name', fn($query) => $query->where('user_id', Auth::id()))
                            ->preload()
                            ->helperText('Auto-populated from the selected lead.')
                            ->columnSpan(1),

                        Select::make('user_id')
                            ->label('Assigned To')
                            ->disabled()
                            ->dehydrated(true)
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
            ]);
    }
}
