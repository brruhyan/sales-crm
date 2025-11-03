<?php

namespace App\Filament\Client\Resources\Contacts\Schemas;

use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Group;

class ContactInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Contact Details')
                            ->description('Information about the contact person')
                            ->icon('heroicon-o-user')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Full Name')
                                    ->icon('heroicon-o-user')
                                    ->copyable()
                                    ->columnSpan(1),

                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable()
                                    ->url(fn ($record) => "mailto:{$record->email}")
                                    ->columnSpan(1),

                                TextEntry::make('phone')
                                    ->label('Phone Number')
                                    ->icon('heroicon-o-phone')
                                    ->copyable()
                                    ->url(fn ($record) => "tel:{$record->phone}")
                                    ->columnSpan(1),
                            ]),

                        Section::make('Company Info')
                            ->description('Company related to the contact')
                            ->icon('heroicon-o-building-office')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('company')
                                    ->label('Company Name')
                                    ->icon('heroicon-o-building-office-2')
                                    ->columnSpan(1),

                                TextEntry::make('position')
                                    ->label('Job Position')
                                    ->icon('heroicon-o-briefcase')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpan(2),

                Group::make()
                    ->schema([
                        Section::make('Related Deals')
                            ->description('Deals associated with this contact')
                            ->icon('heroicon-o-currency-dollar')
                            ->collapsed(false)
                            ->schema([
                                TextEntry::make('deals_count')
                                    ->label('Total Deals')
                                    ->state(fn ($record) => $record->deals()->count())
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('total_deal_value')
                                    ->label('Total Deal Value')
                                    ->state(function ($record) {
                                        $total = $record->deals()->sum('amount');
                                        return '₱' . number_format($total, 2);
                                    })
                                    ->color('warning')
                                    ->weight('bold'),
                            ]),

                        Section::make('Timestamps')
                            ->description('Contact creation and update information')
                            ->icon('heroicon-o-clock')
                            ->columns(1)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('M j, Y H:i:s')
                                    ->icon('heroicon-o-plus-circle'),

                                TextEntry::make('updated_at')
                                    ->label('Updated At')
                                    ->dateTime('M j, Y H:i:s')
                                    ->icon('heroicon-o-arrow-path'),
                            ]),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}