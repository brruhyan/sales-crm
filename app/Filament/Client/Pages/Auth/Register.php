<?php

namespace App\Filament\Client\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                FileUpload::make('documents')
                    ->label('Required Documents')
                    ->helperText('Please upload valid identification documents, certifications, or any required documents. All documents are mandatory.')
                    ->multiple()
                    ->required()
                    ->maxFiles(10)
                    ->acceptedFileTypes(['application/pdf', 'image/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240) // 10MB per file
                    ->disk('public')
                    ->directory('user-documents')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        // Store document paths as JSON
        $data['documents'] = isset($data['documents']) ? json_encode($data['documents']) : json_encode([]);
        $data['password'] = Hash::make($data['password']);
        
        return $data;
    }

    protected function afterRegister(): void
    {
        Notification::make()
            ->title('Registration Successful')
            ->body('Your account has been created successfully. Please wait for an administrator to approve your account before you can login.')
            ->success()
            ->persistent()
            ->send();
    }
}
