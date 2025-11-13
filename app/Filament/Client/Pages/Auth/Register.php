<?php

namespace App\Filament\Client\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\MustVerifyEmail;

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

    protected function getFormActions(): array
    {
        return [
            Action::make('register')
                ->label(__('Register'))
                ->modalHeading('Finalize Registration')
                ->modalSubmitActionLabel('Confirm & Sign up')
                ->form([
                    SignaturePad::make('signature')
                        ->label('Signature')
                        ->required()
                        ->columnSpanFull(),
                    Checkbox::make('accept_terms')
                        ->label('I accept the Terms and Conditions')
                        ->required()
                        ->rules(['accepted'])
                        ->columnSpanFull(),
                ])
                ->before(function (Action $action) {
                    try {
                        $this->authenticate();
                    } catch (ValidationException $e) {
                        $action->halt();
                    }
                })
                ->action(function (array $data) {
                    $mainFormData = $this->form->getState();

                    $allData = array_merge($mainFormData, $data);

                    $allData = $this->mutateFormDataBeforeRegister($allData);

                    $user = $this->handleRegistration($allData);

                    $this->afterRegister();

                    if (! $user instanceof MustVerifyEmail) {
                        $this->guard()->login($user);
                    }

                    $redirectUrl = $this->getRedirectUrl();
                    if (blank($redirectUrl)) {
                        $redirectUrl = filament()->getHomeUrl();
                    }

                    redirect($redirectUrl);
                }),
        ];
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