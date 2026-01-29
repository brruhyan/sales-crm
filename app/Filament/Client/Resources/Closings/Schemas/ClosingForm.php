<?php

namespace App\Filament\Client\Resources\Closings\Schemas;

use App\Models\Deal;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;

class ClosingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Closing Information')
                    ->description('Basic closing details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('deal_id')
                            ->label('Associated Deal')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship(
                                'deal',
                                'title',
                                fn($query) => $query
                                    ->where('user_id', Auth::id())
                                    ->whereIn('status', ['Proposal Sent', 'Negotiation', 'Closed Won'])
                            )
                            ->helperText('Select a deal to auto-populate closing details.')
                            ->live()
                            ->afterStateUpdated(function (?string $state, callable $set) {
                                if ($state) {
                                    $deal = Deal::find($state);
                                    if ($deal) {
                                        $set('title', 'Closing of ' . $deal->title);
                                        $set('contact_id', $deal->contact_id);
                                        $set('amount', $deal->amount);
                                        $set('probability', $deal->probability ?? 0);
                                        $set('expected_close_date', $deal->expected_close_date);
                                    }
                                } else {
                                    $set('title', '');
                                    $set('contact_id', null);
                                    $set('amount', null);

                                    $set('probability', 0);
                                    $set('expected_close_date', null);
                                }
                            })
                            ->columnSpan(2),

                        TextInput::make('title')
                            ->label('Closing Title')
                            ->disabled()
                            ->dehydrated(condition: true)
                            ->helperText('Auto-populated from the associated deal.')
                            ->required()
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Open' => 'Open',
                                'In Progress' => 'In Progress',
                                'Pending Documentation' => 'Pending Documentation',
                                'Closed Won' => 'Closed Won',
                                'Closed Lost' => 'Closed Lost',
                            ])
                            ->default('In Progress')
                            ->required()
                            ->live()
                            ->columnSpan(1),

                        TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01)
                            ->columnSpan(1),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Associations')
                    ->description('Contact and supporting information')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('contact_id')
                            ->label('Contact')
                            ->disabled()
                            ->dehydrated(true)
                            ->relationship('contact', 'name', fn($query) => $query->where('user_id', Auth::id()))
                            ->preload()
                            ->helperText('Auto-populated from the selected deal.')
                            ->columnSpan(2),
                    ]),
                Section::make('Timeline')
                    ->description('Important dates')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        DatePicker::make('expected_close_date')
                            ->label('Expected Close Date')
                            ->disabled()
                            ->dehydrated(true)
                            ->helperText('Auto-populated from the selected deal.')
                            ->columnSpan(1),

                       DatePicker::make('actual_close_date')
                            ->label('Actual Close Date')
                            ->required()
                            ->native(condition: false)
                            ->columnSpan(1),
                    ]),

            ]);
    }
}
