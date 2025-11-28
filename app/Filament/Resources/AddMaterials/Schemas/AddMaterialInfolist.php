<?php

namespace App\Filament\Resources\AddMaterials\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class AddMaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Enter the material title')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('title')
                            ->label('Material Title')
                            ->columnSpanFull(),
                    ]),
                Section::make('Material Details')
                    ->description('Add detailed information about your material')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('learn_more')
                            ->label('Learn More Link')
                            ->url(fn($record) => $record->learn_more)
                            ->openUrlInNewTab()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
                Section::make('Media')
                    ->description('Attach media files (PDF, video, images, etc.)')
                    ->icon('heroicon-o-document-arrow-down')
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('media')
                            ->label('Uploaded Media')
                            ->state(function ($record) {
                                if (empty($record->media)) {
                                    return null;
                                }

                                $media = $record->media;
                                $filename = basename($media);
                                $encodedPath = str_replace(' ', '%20', $media);
                                $url = url('storage/' . $encodedPath);
                                $fileExtension = strtolower(pathinfo($media, PATHINFO_EXTENSION));

                                $icon = match (true) {
                                    in_array($fileExtension, ['pdf']) => '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12V6h-4V2H4v16zm-2 1V0h10l4 4v16H2v-1z"/></svg>',
                                    in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) => '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3zm2 2v10h8V5H6z"/></svg>',
                                    in_array($fileExtension, ['mp4', 'webm', 'avi', 'mkv']) => '<svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm4 2v4h8V8H6z"/></svg>',
                                    in_array($fileExtension, ['mp3', 'wav', 'aac', 'm4a']) => '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2v8a1 1 0 001 1h1a1 1 0 001-1V4a1 1 0 000-2H9z"/></svg>',
                                    default => '<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3z"/></svg>',
                                };

                                return "<div class='flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition'>
                                    <div class='flex-shrink-0'>{$icon}</div>
                                    <div class='flex-1 min-w-0'>
                                        <a href=\"{$url}\" target=\"_blank\" rel=\"noopener noreferrer\" 
                                           class=\"text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium block cursor-pointer no-underline hover:underline\">
                                            {$filename}
                                        </a>
                                    </div>
                                </div>";
                            })
                            ->html()
                            ->placeholder('No media uploaded.')
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
