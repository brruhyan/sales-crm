<?php

namespace App\Filament\Client\Resources\Deals\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Actions;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Storage;
use Filament\Support\Enums\IconPosition;

class DealInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Section::make('Deal Information')
                            ->description('Basic deal details')
                            ->icon('heroicon-o-document-text')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Deal Title')
                                    ->icon('heroicon-o-briefcase')
                                    ->copyable()
                                    ->columnSpan(1),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Prospecting' => 'gray',
                                        'Qualification' => 'info',
                                        'Needs Analysis' => 'primary',
                                        'Proposal' => 'warning',
                                        'Negotiation' => 'warning',
                                        'Closed Won' => 'success',
                                        'Closed Lost' => 'danger',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),

                                TextEntry::make('probability')
                                    ->label('Win Probability')
                                    ->formatStateUsing(fn ($state) => $state . '%')
                                    ->badge()
                                    ->color(fn ($state): string => match (true) {
                                        $state >= 75 => 'success',
                                        $state >= 50 => 'warning',
                                        $state >= 25 => 'info',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),

                                TextEntry::make('description')
                                    ->label('Description')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Financial Details')
                            ->description('Deal value and financial information')
                            ->icon('heroicon-o-currency-dollar')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('amount')
                                    ->label('Deal Value')
                                    ->money(fn ($record) => $record->currency)
                                    ->weight('bold')
                                    ->size('lg')
                                    ->color('success')
                                    ->columnSpan(1),

                                TextEntry::make('currency')
                                    ->label('Currency')
                                    ->badge()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make()
                    ->schema([
                        Section::make('Associations')
                            ->description('Contact and team member assignment')
                            ->icon('heroicon-o-users')
                            ->collapsed(false)
                            ->columns(3)
                            ->schema([
                                TextEntry::make('contact.name')
                                    ->label('Contact')
                                    ->icon('heroicon-o-user')
                                    ->url(fn ($record) => $record->contact ? route('filament.client.resources.contacts.view', $record->contact) : null),

                                TextEntry::make('contact.email')
                                    ->label('Contact Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable()
                                    ->url(fn ($record) => $record->contact ? "mailto:{$record->contact->email}" : null),

                                TextEntry::make('contact.phone')
                                    ->label('Contact Phone')
                                    ->icon('heroicon-o-phone')
                                    ->copyable()
                                    ->url(fn ($record) => $record->contact ? "tel:{$record->contact->phone}" : null),

                                TextEntry::make('contact.company')
                                    ->label('Company')
                                    ->icon('heroicon-o-building-office'),

                                TextEntry::make('user.name')
                                    ->label('Assigned To')
                                    ->icon('heroicon-o-user-circle')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('source')
                                    ->label('Source')
                                    ->badge()
                                    ->icon('heroicon-o-link')
                                    ->color('gray'),
                            ]),

                        Section::make('Timeline')
                            ->description('Deal timeline and important dates')
                            ->icon('heroicon-o-clock')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('expected_close_date')
                                    ->label('Expected Close Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar'),

                                TextEntry::make('actual_close_date')
                                    ->label('Actual Close Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar-days')
                                    ->placeholder('Not closed yet'),

                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('M j, Y H:i:s')
                                    ->icon('heroicon-o-plus-circle'),

                                TextEntry::make('updated_at')
                                    ->label('Updated At')
                                    ->dateTime('M j, Y H:i:s')
                                    ->icon('heroicon-o-arrow-path'),
                            ]),
                        Section::make('Supporting Documents')
                            ->description('Uploaded documents related to the deal')
                            ->icon('heroicon-o-paper-clip')
                            ->columns(1)
                            ->schema([
                                TextEntry::make('documents')
                                    ->label('Uploaded Files')
                                    ->state(function ($record) {
                                        if (empty($record->documents) || !is_array($record->documents)) {
                                            return null;
                                        }
                                        return collect($record->documents)->map(function ($doc) {
                                            $filename = basename($doc);
                                            // URL encode the path properly for spaces and special characters
                                            $encodedPath = str_replace(' ', '%20', $doc);
                                            $url = url('storage/' . $encodedPath);
                                            $fileExtension = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                                            
                                            // Check if file exists
                                            $fileExists = Storage::disk('public')->exists($doc);
                                            
                                            // Determine icon based on file type
                                            $icon = match(true) {
                                                in_array($fileExtension, ['pdf']) => '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12V6h-4V2H4v16zm-2 1V0h10l4 4v16H2v-1z"/></svg>',
                                                in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) => '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3zm2 2v10h8V5H6z"/></svg>',
                                                default => '<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3z"/></svg>',
                                            };
                                            
                                            $statusBadge = !$fileExists ? '<span class="text-xs text-red-600 dark:text-red-400">(File not found)</span>' : '';
                                            
                                            return "<div class='flex items-center gap-3 p-3 mb-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition'>
                                                <div class='flex-shrink-0'>{$icon}</div>
                                                <div class='flex-1 min-w-0'>
                                                    <a href=\"{$url}\" target=\"_blank\" rel=\"noopener noreferrer\" 
                                                       onclick=\"window.open('{$url}', '_blank'); return false;\"
                                                       class=\"text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium block cursor-pointer no-underline hover:underline\">
                                                        {$filename}
                                                    </a>
                                                </div>

                                            </div>";
                                        })->join('');
                                    })
                                    ->html()
                                    ->placeholder('No documents uploaded.')
                                    ->columnSpan(1),
                            ]),
                        ])
                        ->columnSpanFull(),
            ]);
    }
}