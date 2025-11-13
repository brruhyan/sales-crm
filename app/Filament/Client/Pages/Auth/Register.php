<?php

namespace App\Filament\Client\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;

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
                TextInput::make('tin_number')
                    ->label('Tax Identification Number (TIN)')
                    ->required()
                    ->mask('999-999-999')
                    ->maxLength(11)
                    ->columnSpanFull(),
                TextInput::make('home_address')
                    ->label('Home Address')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('documents')
                    ->label('Required Documents')
                    ->helperText('Please upload valid identification documents.')
                    ->multiple()
                    ->required()
                    ->maxFiles(10)
                    ->acceptedFileTypes(['application/pdf', 'image/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240) 
                    ->disk('public')
                    ->directory('user-documents')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {

        if (!isset($data['documents']) || !is_array($data['documents'])) {
            $data['documents'] = [];
        }
        
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
