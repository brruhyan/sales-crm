<?php

namespace App\Filament\Resources\AddMaterials\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;

class AddMaterialForm
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
                        TextInput::make('title')
                            ->label('Material Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make('Material Details')
                    ->description('Add detailed information about your material')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),

                Section::make('Media')
                    ->description('Attach media files (PDF, video, images, etc.)')
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('media')
                            ->label('Upload Media')
                            ->helperText('Upload presentation materials, videos, PDFs, or other media files.')
                            ->acceptedFileTypes(['video/*', 'audio/*', 'application/pdf', 'image/*'])
                            ->maxSize(102400)
                            ->disk('public')
                            ->directory('materials')
                            ->columnSpanFull(),

                        TextInput::make('learn_more')
                            ->label('Learn More Link')
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->helperText('Provide a URL for more information about this material.')
                            ->columnSpanFull(),
                    ]),


            ]);
    }
}
