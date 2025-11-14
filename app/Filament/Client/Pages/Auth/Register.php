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
use Filament\Forms\Components\Select;
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
                Select::make('account_type')
                    ->label('Account Type')
                    ->options([
                        'individual' => 'Individual',
                        'company' => 'Company',
                    ])
                    ->required()
                    ->default('individual')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('register')
                ->label(__('Continue Registration'))
                ->modalHeading('Finalize Registration')
                ->modalSubmitActionLabel('Confirm & Sign up')
                ->modalWidth('sm')
                ->form(function () {
                    $accountType = $this->form->getState()['account_type'] ?? 'individual';
                    
                    $components = [];

                    if ($accountType === 'individual') {
                        $components[] = TextInput::make('tin_number')
                            ->label('Tax Identification Number (TIN)')
                            ->required()
                            ->mask('999-999-999')
                            ->maxLength(11)
                            ->columnSpanFull();
                        
                        $components[] = FileUpload::make('modal_documents')
                            ->label('Required Documents')
                            ->helperText('Valid govt ID.')
                            ->multiple()
                            ->required()
                            ->maxFiles(10)
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->maxSize(10240)
                            ->disk('public')
                            ->directory('user-documents')
                            ->columnSpanFull();
                    } else {
                        $components[] = FileUpload::make('company_documents')
                            ->label('Company Requirements')
                            ->helperText('Upload SEC registration cert and BIR 2303 in one PDF file.')
                            ->required()
                            ->maxFiles(1)
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240)
                            ->disk('public')
                            ->directory('user-documents')
                            ->columnSpanFull();
                    }

                    $components[] = SignaturePad::make('signature')
                        ->label('Signature')
                        ->required()
                        ->columnSpanFull();

                    $components[] = Checkbox::make('accept_terms')
                        ->label('I accept the Terms and Conditions')
                        ->required()
                        ->rules(['accepted'])
                        ->columnSpanFull();


                    return $components;
                })
                ->before(function (Action $action) {
                })
                ->action(function (array $data) {
                    $mainFormData = $this->form->getState();
                    $accountType = $mainFormData['account_type'] ?? 'individual';

                    $allData = array_merge($mainFormData, $data);

                    if ($accountType === 'individual') {
                        if (isset($data['modal_documents']) && !empty($data['modal_documents'])) {
                            $allData['documents'] = $data['modal_documents'];
                        } else {
                            $allData['documents'] = [];
                        }
                        $allData['tin_number'] = $data['tin_number'] ?? null;
                    } else {
                        if (isset($data['company_documents']) && !empty($data['company_documents'])) {
                            $allData['documents'] = $data['company_documents'];
                        } else {
                            $allData['documents'] = [];
                        }
                        $allData['tin_number'] = null;
                    }

                    $allData = $this->mutateFormDataBeforeRegister($allData);

                    $user = $this->handleRegistration($allData);

                    $this->afterRegister();

                    redirect(route('filament.client.auth.login'));
                }),
        ];
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        // Ensure documents is properly set and is an array
        if (!isset($data['documents'])) {
            $data['documents'] = [];
        } elseif (!is_array($data['documents'])) {
            $data['documents'] = [$data['documents']];
        }
        
        // Remove modal-specific document fields as they've been merged into 'documents'
        unset($data['modal_documents']);
        unset($data['company_documents']);
        
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
