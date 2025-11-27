<?php

namespace App\Filament\Resources\AddProducts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;

class AddProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Enter the product or service name')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('product_name')
                            ->label('Service Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make('Product Details')
                    ->description('Add detailed information about your product or service')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        TextInput::make('link')
                            ->label('Link')
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->helperText('Provide a URL for more information about this product.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Media')
                    ->description('Attach media files (PDF, video, images, etc.)')
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('media')
                            ->label('Upload Media')
                            ->helperText('Upload product materials, demos, PDFs, or other media files.')
                            ->acceptedFileTypes(['video/*', 'audio/*', 'application/pdf', 'image/*'])
                            ->maxSize(102400)
                            ->disk('public')
                            ->directory('products')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
