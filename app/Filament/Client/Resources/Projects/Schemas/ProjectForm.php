<?php

namespace App\Filament\Client\Resources\Projects\Schemas;

use App\Models\Deal;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Project Information')
                    ->description('Basic project details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Project Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Notice to Proceed' => 'Notice to Proceed',
                                'Ongoing' => 'Ongoing',
                                'Finished' => 'Finished',
                            ])
                            ->default('Notice to Proceed')
                            ->required()
                            ->columnSpan(1),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Project Details')
                    ->description('Timeline and budget information')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('deal_id')
                            ->label('Associated Deal')
                            ->relationship(
                                'deal', 
                                'title',
                                fn($query) => $query->where('status', 'Closed Won')
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Only deals with status "Closed Won" are selectable')
                            ->columnSpan(1),

                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->native(false)
                            ->columnSpan(1),

                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->native(false)
                            ->columnSpan(1),

                        TextInput::make('budget')
                            ->label('Project Budget')
                            ->numeric()
                            ->prefix('₱')
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
