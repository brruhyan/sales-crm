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
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('media')
                            ->label('Upload Media')
                            ->url(fn($record) => $record->media ? '/storage/' . $record->media : null)
                            ->openUrlInNewTab()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
