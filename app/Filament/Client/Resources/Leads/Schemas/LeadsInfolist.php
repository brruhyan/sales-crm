<?php

namespace App\Filament\Client\Resources\Leads\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\BadgeEntry;
use App\Models\Leads;

class LeadsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead Details')
                    ->description('Lead and Company Information')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('status')
                            ->label('Current Status')
                            ->badge(fn ($record) => match ($record->status) {
                                'New' => 'primary',
                                'Contacted' => 'warning',
                                'Qualified' => 'success',
                                'Lost' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('source')
                            ->label('Source')
                            ->badge(fn ($record) => match ($record->source) {
                                'Website' => 'primary',
                                'Referral' => 'info',
                                'Social Media' => 'success',
                                'Other' => 'gray',
                                default => 'gray',
                            }),
                        
                        TextEntry::make('company')
                            ->label('Company')
                            ->color('gray'),
                    ]),
                
                Section::make('Contact Details')
                    ->description('Information about the lead\'s contact person')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('phone')
                            ->label('Phone'),
                    ]),
                
                Section::make('Timestamps')
                    ->description('Information about lead creation and updates')
                    ->columns(6)
                    ->columnSpanFull() 
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime()
                            ->placeholder('-')
                            ->columnSpan(2),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime()
                            ->placeholder('Pending')
                            ->columnSpan(2),
                    ]),
            ]);
    }
}