<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Storage;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
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
                        TextEntry::make('tin_number')
                            ->label('Tax Identification Number (TIN)')
                            ->icon('heroicon-o-identification')
                            ->columnSpan(1),
                        IconEntry::make('accept_terms')
                            ->label('Accepted Terms and Conditions')
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle'),
                        IconEntry::make('signature')
                            ->label('Provided Signature')
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle'),
                        TextEntry::make('account_type')
                            ->label('Account Type')
                            ->badge()
                            ->color('Amber')
                            ->icon('heroicon-o-briefcase')
                            ->state(fn ($record) => ucwords(str_replace('_', ' ', $record->account_type))),
                    ])
                    ->columnSpanFull(),

                Section::make('Account Status')
                    ->columns(3)
                    ->schema([
                        IconEntry::make('is_admin')
                            ->label('Admin User')
                            ->boolean()
                            ->columnSpan(1)
                            ->trueIcon('heroicon-o-shield-check')
                            ->falseIcon('heroicon-o-shield-exclamation')
                            ->trueColor('warning')
                            ->falseColor('gray'),
                        IconEntry::make('approved')
                            ->label('Approved')
                            ->boolean()
                            ->columnSpan(1)
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
                    ->columnSpanFull(),

                Section::make('Documents')
                    ->description('Uploaded documents from user registration')
                    ->icon('heroicon-o-paper-clip')
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('documents')
                            ->label('Uploaded Documents')
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
                                        in_array($fileExtension, ['pdf']) =>
                                            '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12V6h-4V2H4v16zm-2 1V0h10l4 4v16H2v-1z"/></svg>',
                                        in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) =>
                                            '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3zm2 2v10h8V5H6z"/></svg>',
                                        default =>
                                            '<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3z"/></svg>',
                                    };

                                    $statusBadge = !$fileExists
                                        ? '<span class="text-xs text-red-600 dark:text-red-400">(File not found)</span>'
                                        : '';

                                    $typeBadge = '<span class="text-xs bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-2 py-1 rounded-full">Registration Document</span>';

                                    return "
                                        <div class='flex items-center gap-3 p-3 mb-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition'>
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
                                        </div>
                                    ";
                                })->join('');
                            })
                            ->html()
                            ->placeholder('No documents uploaded.')
                            ->columnSpan(1),
                    ]),

                Section::make('Signature')
                    ->description('User signature from registration')
                    ->icon('heroicon-o-pencil')
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('signature')
                            ->label('Signature')
                            ->state(function ($record) {
                                if (empty($record->signature)) {
                                    return null;
                                }

                                $signature = $record->signature;
                                
                                // Displays Base64 string directly
                                if (strpos($signature, 'data:image/') === 0) {
                                    return "
                                        <img src=\"{$signature}\" alt=\"User Signature\" class='max-h-24 w-auto'/> 
                                    ";
                                }
                                
                                // Displays file path (if saved as a file)
                                if (is_string($signature)) {
                                    $encodedPath = str_replace(' ', '%20', $signature);
                                    $url = url('storage/' . $encodedPath);
                                    $fileExists = Storage::disk('public')->exists($signature);
                                    
                                    if ($fileExists) {
                                        return "
                                            <a href=\"{$url}\" target=\"_blank\" rel=\"noopener noreferrer\">
                                                <img src=\"{$url}\" alt=\"User Signature\" class='max-h-24 cursor-pointer hover:opacity-80 transition' />
                                            </a>
                                        ";
                                    }
                                }

                                return null;
                            })
                            ->html()
                            ->placeholder('No signature provided.')
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
