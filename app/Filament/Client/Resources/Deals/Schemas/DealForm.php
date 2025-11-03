<?php

namespace App\Filament\Client\Resources\Deals\Schemas;

use App\Models\Contact;
use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;

class DealForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Deal Information')
                    ->description('Basic deal details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label('Deal Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Prospecting' => 'Prospecting',
                                'Qualification' => 'Qualification',
                                'Needs Analysis' => 'Needs Analysis',
                                'Proposal' => 'Proposal',
                                'Negotiation' => 'Negotiation',
                                'Closed Won' => 'Closed Won',
                                'Closed Lost' => 'Closed Lost',
                            ])
                            ->default('Prospecting')
                            ->required()
                            ->columnSpan(1),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
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

                Section::make('Associations')
                    ->description('Contact and team member assignment')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('contact_id')
                            ->label('Contact')
                            ->relationship('contact', 'name')
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
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        Select::make('source')
                            ->label('Deal Source')
                            ->options([
                                'Inbound Lead' => 'Inbound Lead',
                                'Outbound' => 'Outbound',
                                'Referral' => 'Referral',
                                'Website' => 'Website',
                                'Social Media' => 'Social Media',
                                'Event' => 'Event',
                                'Partner' => 'Partner',
                                'Other' => 'Other',
                            ])
                            ->columnSpan(1),
                    ]),

                Section::make('Timeline')
                    ->description('Deal timeline and important dates')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        DatePicker::make('expected_close_date')
                            ->label('Expected Close Date')
                            ->native(false)
                            ->columnSpan(1),

                        DatePicker::make('actual_close_date')
                            ->label('Actual Close Date')
                            ->native(false)
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
