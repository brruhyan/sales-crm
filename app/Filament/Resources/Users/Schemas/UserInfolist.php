<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name')
                            ->icon('heroicon-o-user'),
                        TextEntry::make('email')
                            ->label('Email Address')
                            ->icon('heroicon-o-envelope')
                            ->copyable(),
                    ])
                    ->columns(2),
                
                Section::make('Account Status')
                    ->schema([
                        IconEntry::make('approved')
                            ->label('Approved')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        TextEntry::make('email_verified_at')
                            ->label('Email Verified At')
                            ->dateTime('M j, Y H:i:s')
                            ->placeholder('Not verified')
                            ->icon('heroicon-o-shield-check'),
                    ])
                    ->columns(2),
                
                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('M j, Y H:i:s')
                            ->icon('heroicon-o-clock'),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime('M j, Y H:i:s')
                            ->icon('heroicon-o-arrow-path'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
