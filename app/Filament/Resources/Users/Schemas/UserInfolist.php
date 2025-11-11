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
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Section::make('User Information')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Name')
                                    ->columnSpan(1)
                                    ->icon('heroicon-o-user'),
                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable(),
                            ]),
                        Section::make('Account Status')
                            ->schema([
                                IconEntry::make('is_admin')
                                    ->label('Admin User')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-shield-check')
                                    ->falseIcon('heroicon-o-shield-exclamation')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),
                                IconEntry::make('approved')
                                    ->label('Approved')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                                TextEntry::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->dateTime('M j, Y')
                                    ->placeholder('Not verified')
                                    ->icon('heroicon-o-shield-check'),
                            ])
                            ->columns(3),
                    ]),
            ]);
    }
}
