<?php

namespace App\Filament\Resources\AddProducts\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class AddProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Service information')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('product_name')
                            ->label('Service Name')
                            ->columnSpanFull(),
                    ]),
                Section::make('Service Details')
                    ->description('Add detailed information about your service')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('description')
                            ->placeholder('-')
                            ->columnSpan(1),
                        TextEntry::make('link')
                            ->label('Learn More')
                            ->color('info')
                            ->url(fn($record) => $record->link)
                            ->openUrlInNewTab()
                            ->placeholder('-')
                            ->columnSpan(1),
                    ]),
                Section::make('Media')
                    ->description('Attach media files (PDF, video, images, etc.)')
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('media')
                            ->label('Upload Media')
                            ->color('info')
                            ->url(fn($record) => $record->media ? '/storage/' . $record->media : null)
                            ->openUrlInNewTab()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
