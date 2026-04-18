<?php

namespace App\Filament\User\Pages;

use App\Jobs\DistributeCommissionJob;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use App\Models\User;
use Illuminate\Database\QueryException;
use Filament\Notifications\Notification;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sponsor_id')
                    ->label('Sponsor ID / Referral Code')
                    ->placeholder('Enter sponsor referral code')
                    ->helperText('If you have a sponsor, enter their referral code')
                    ->maxLength(255),

                TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Mobile Number')
                    ->tel()
                    ->required()
                    ->unique(table: 'users', column: 'phone', ignorable: fn ($record) => $record)
                    ->maxLength(20),

                TextInput::make('pan_number')
                    ->label('PAN Number')
                    ->placeholder('ABCDE1234F')
                    ->required()
                    ->minLength(10)
                    ->maxLength(10)
                    ->rule('regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/')
                    ->unique(table: 'users', column: 'pan_number')
                    ->helperText('Enter 10-character PAN (e.g. HEASS2345H)')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state)),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->unique(table: 'users', column: 'email', ignorable: fn ($record) => $record)
                    ->maxLength(255),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(6)
                    ->maxLength(255),

                TextInput::make('passwordConfirmation')
                    ->label('Confirm Password')
                    ->password()
                    ->required()
                    ->same('password')
                    ->maxLength(255),
            ]);
    }

    protected function handleRegistration(array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            $sponsor = null;
            if (!empty($data['sponsor_id'])) {
                $sponsor = User::where('referral_code', $data['sponsor_id'])->first();

                if (!$sponsor) {
                    Notification::make()
                        ->title('Invalid Sponsor ID')
                        ->body('The sponsor referral code you entered is invalid.')
                        ->danger()
                        ->send();
                    throw new \Exception('Invalid sponsor referral code');
                }
            }

            if (User::where('email', $data['email'])->exists()) {
                Notification::make()->title('Email Already Exists')
                    ->body('This email is already registered.')->danger()->send();
                throw new \Exception('Email already exists');
            }

            if (User::where('phone', $data['phone'])->exists()) {
                Notification::make()->title('Phone Already Exists')
                    ->body('This phone number is already registered.')->danger()->send();
                throw new \Exception('Phone already exists');
            }

            if (User::where('pan_number', strtoupper($data['pan_number']))->exists()) {
                Notification::make()->title('PAN Already Registered')
                    ->body('This PAN number is already linked to another account.')->danger()->send();
                throw new \Exception('PAN already exists');
            }

            $referralCode = $this->generateReferralCode();

            $user = User::create([
                'name'           => $data['name'],
                'email'          => $data['email'],
                'phone'          => $data['phone'],
                'pan_number'     => strtoupper($data['pan_number']),
                'password'       => bcrypt($data['password']),
                'referral_code'  => $referralCode,
                'referred_by'    => $sponsor ? $sponsor->id : null,
                'role'           => 'user',
                'status'         => 'active',
                'wallet_balance' => 0,
                'total_earned'   => 0,
                'left_count'     => 0,
                'right_count'    => 0,
            ]);

            if ($sponsor) {
                $this->assignBinaryPosition($user, $sponsor);

                $mlmSetting = \App\Models\MlmSetting::getActive();
                if ($mlmSetting && $mlmSetting->registration_fee > 0) {
                    DistributeCommissionJob::dispatch($user->id, $mlmSetting->registration_fee, 'registration');
                }
            }

            Notification::make()->title('Registration Successful')
                ->body('Welcome! Your account has been created.')->success()->send();

            return $user;

        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                Notification::make()->title('Registration Failed')
                    ->body('Email, phone or PAN already exists.')->danger()->send();
            }
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function generateReferralCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 8));
        } while (User::where('referral_code', $code)->exists());
        return $code;
    }

    private function assignBinaryPosition($user, $sponsor): void
    {
        if ($sponsor->left_count <= $sponsor->right_count) {
            $user->position = 'left';
            $sponsor->increment('left_count');
        } else {
            $user->position = 'right';
            $sponsor->increment('right_count');
        }
        $user->save();
    }

    protected function getRedirectUrl(): string
    {
        return '/user/dashboard';
    }
}