<?php

namespace App\Filament\Client\Resources\Contacts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Details')
                    ->description('Information about the contact person')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('phone')
                            ->label('Phone'),
                    ]),

                Section::make('Company Info')
                    ->description('Company related to the contact')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('company')
                            ->label('Company'),
                        TextEntry::make('position')
                            ->label('Position'),
                    ]),

                Section::make('Timestamps')
                    ->description('Information about contact creation and updates')
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
