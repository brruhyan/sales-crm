<?php

namespace App\Filament\Resources\LeadTrackings\Schemas;

use App\Models\Deal;
use App\Models\Leads;
use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Facades\Storage;

class LeadTrackingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Section::make('Lead Information')
                            ->description('Basic lead details')
                            ->icon('heroicon-o-user-group')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('lead_title')
                                    ->label('Lead Title')
                                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                    ->copyable()
                                    ->columnSpan(1),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'New' => 'info',
                                        'Contacted' => 'warning',
                                        'Qualified' => 'success',
                                        'Declined' => 'danger',
                                        'Lost' => 'danger',
                                        'For Review' => 'danger',
                                        'Disputed' => 'danger',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),

                                TextEntry::make('lead_type')
                                    ->label('Lead Type')
                                    ->badge()
                                    ->color('primary')
                                    ->columnSpan(1),
                            ]),

                        Section::make('Contact Information')
                            ->description('Lead contact details')
                            ->icon('heroicon-o-identification')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Name')
                                    ->icon('heroicon-o-user')
                                    ->copyable()
                                    ->columnSpan(1),

                                TextEntry::make('email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable()
                                    ->url(fn ($record) => "mailto:{$record->email}")
                                    ->columnSpan(1),

                                TextEntry::make('phone')
                                    ->label('Phone')
                                    ->icon('heroicon-o-phone')
                                    ->copyable()
                                    ->url(fn ($record) => "tel:{$record->phone}")
                                    ->columnSpan(1),

                                TextEntry::make('partner.name')
                                    ->label('Company')
                                    ->icon('heroicon-o-building-office')
                                    ->placeholder('No company')
                                    ->columnSpan(1),
                            ]),

                        Section::make('Product Information')
                            ->description('Product and category details')
                            ->icon('heroicon-o-archive-box')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('product')
                                    ->label('Product(s)')
                                    ->icon('heroicon-o-cube-transparent')
                                    ->state(function ($record) {
                                        $state = $record->product;
                                        if (empty($state)) {
                                            return 'No products selected';
                                        }
                                        $ids = is_array($state) ? $state : json_decode($state, true);
                                        if (!is_array($ids) || empty($ids)) {
                                            return 'No products selected';
                                        }
                                        return \App\Models\ProductList::whereIn('id', $ids)->pluck('name')->implode(', ');
                                    })
                                    ->columnSpan(1),

                                TextEntry::make('source')
                                    ->label('Source')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Website' => 'primary',
                                        'Referral' => 'info',
                                        'Social Media' => 'success',
                                        'Event' => 'warning',
                                        'Cold Call' => 'gray',
                                        'Other' => 'gray',
                                        default => 'gray',
                                    })
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make()
                    ->schema([
                        Section::make('Associations')
                            ->description('User assignment')
                            ->icon('heroicon-o-users')
                            ->collapsed(false)
                            ->columns(1)
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label('Assigned To')
                                    ->icon('heroicon-o-user-circle')
                                    ->badge()
                                    ->color('info'),
                            ]),

                        Section::make('Timeline')
                            ->description('Record creation and update times')
                            ->icon('heroicon-o-clock')
                            ->columns(2)
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

                        Section::make('Supporting Documents')
                            ->description('Uploaded documents related to the lead')
                            ->icon('heroicon-o-paper-clip')
                            ->columns(1)
                            ->schema([
                                TextEntry::make('documents')
                                    ->label('Initial Documents')
                                    ->state(function ($record) {
                                        if (empty($record->documents) || !is_array($record->documents)) {
                                            return null;
                                        }
                                        return collect($record->documents)->map(function ($doc) {
                                            $filename = basename($doc);
                                            $encodedPath = str_replace(' ', '%20', $doc);
                                            $url = url('storage/' . $encodedPath);
                                            $fileExtension = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                                            $fileExists = Storage::disk('public')->exists($doc);

                                            $icon = match (true) {
                                                in_array($fileExtension, ['pdf']) => '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12V6h-4V2H4v16zm-2 1V0h10l4 4v16H2v-1z"/></svg>',
                                                in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) => '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3zm2 2v10h8V5H6z"/></svg>',
                                                default => '<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3z"/></svg>',
                                            };

                                            $statusBadge = !$fileExists ? '<span class="text-xs text-red-600 dark:text-red-400">(File not found)</span>' : '';
                                            $typeBadge = '<span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full">Initial Document</span>';

                                            return "<div class='flex items-center gap-3 p-3 mb-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition'>
                                                <div class='flex-shrink-0'>{$icon}</div>
                                                <div class='flex-1 min-w-0'>
                                                    <a href=\"{$url}\" target=\"_blank\" rel=\"noopener noreferrer\" 
                                                       onclick=\"window.open('{$url}', '_blank'); return false;\"
                                                       class=\"text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium block cursor-pointer no-underline hover:underline\">
                                                        {$filename}
                                                    </a>
                                                    <div class='flex gap-2 mt-1'>
                                                        {$typeBadge}
                                                        {$statusBadge}
                                                    </div>
                                                </div>
                                            </div>";
                                        })->join('');
                                    })
                                    ->html()
                                    ->placeholder('No initial documents uploaded.')
                                    ->columnSpan(1),

                                TextEntry::make('qualified_documents')
                                    ->label('Qualified Documents')
                                    ->state(function ($record) {
                                        if (empty($record->qualified_documents) || !is_array($record->qualified_documents)) {
                                            return null;
                                        }
                                        return collect($record->qualified_documents)->map(function ($doc) {
                                            $filename = basename($doc);
                                            $encodedPath = str_replace(' ', '%20', $doc);
                                            $url = url('storage/' . $encodedPath);
                                            $fileExtension = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                                            $fileExists = Storage::disk('public')->exists($doc);

                                            $icon = match (true) {
                                                in_array($fileExtension, ['pdf']) => '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12V6h-4V2H4v16zm-2 1V0h10l4 4v16H2v-1z"/></svg>',
                                                in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) => '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3zm2 2v10h8V5H6z"/></svg>',
                                                default => '<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3z"/></svg>',
                                            };

                                            $statusBadge = !$fileExists ? '<span class="text-xs text-red-600 dark:text-red-400">(File not found)</span>' : '';
                                            $typeBadge = '<span class="text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded-full">Qualified Document</span>';

                                            return "<div class='flex items-center gap-3 p-3 mb-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition'>
                                                <div class='flex-shrink-0'>{$icon}</div>
                                                <div class='flex-1 min-w-0'>
                                                    <a href=\"{$url}\" target=\"_blank\" rel=\"noopener noreferrer\" 
                                                       onclick=\"window.open('{$url}', '_blank'); return false;\"
                                                       class=\"text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium block cursor-pointer no-underline hover:underline\">
                                                        {$filename}
                                                    </a>
                                                    <div class='flex gap-2 mt-1'>
                                                        {$typeBadge}
                                                        {$statusBadge}
                                                    </div>
                                                </div>
                                            </div>";
                                        })->join('');
                                    })
                                    ->html()
                                    ->placeholder('No qualified documents uploaded.')
                                    ->columnSpan(1),
                            ]),
                        ])
                        ->columnSpanFull(),
            ]);
    }
}

