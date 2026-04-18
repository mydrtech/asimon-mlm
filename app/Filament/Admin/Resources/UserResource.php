<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('phone')
                            ->label('Mobile Number')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('pan_number')
                            ->label('PAN Number')
                            ->placeholder('ABCDE1234F')
                            ->minLength(10)
                            ->maxLength(10)
                            ->rule('regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/')
                            ->unique(ignoreRecord: true)
                            ->dehydrateStateUsing(fn ($state) => $state ? strtoupper($state) : null),
                        
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(6)
                            ->maxLength(255),
                    ])->columns(2),
                
                Forms\Components\Section::make('MLM Information')
                    ->schema([
                        Forms\Components\TextInput::make('referral_code')
                            ->label('Referral Code')
                            ->maxLength(8)
                            ->unique(ignoreRecord: true)
                            ->helperText('Unique 8-character code'),
                        
                        Forms\Components\Select::make('referred_by')
                            ->label('Sponsored By')
                            ->relationship('referrer', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Who referred this user'),
                        
                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Admin',
                                'sub_admin' => 'Sub Admin',
                                'user' => 'User',
                            ])
                            ->required()
                            ->default('user'),
                        
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'suspended' => 'Suspended',
                            ])
                            ->required()
                            ->default('active'),
                        
                        
                    ])->columns(2),
                
                Forms\Components\Section::make('Financial Information')
                    ->schema([
                        Forms\Components\TextInput::make('wallet_balance')
                            ->label('Wallet Balance (₹)')
                            ->numeric()
                            ->default(0)
                            ->prefix('₹'),
                        
                        Forms\Components\TextInput::make('total_earned')
                            ->label('Total Earned (₹)')
                            ->numeric()
                            ->default(0)
                            ->prefix('₹')
                            ->disabled()
                            ->helperText('Auto-calculated from commissions'),
                        
                        
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope'),
                
                Tables\Columns\TextColumn::make('phone')
                    ->label('Mobile')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('pan_number')
                    ->label('PAN Number')
                    ->searchable()
                    ->badge()
                    ->color('warning')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('referral_code')
                    ->label('Referral Code')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('referrer.name')
                    ->label('Sponsored By')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'sub_admin' => 'warning',
                        'user' => 'success',
                    }),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'suspended' => 'danger',
                    }),
                
                Tables\Columns\TextColumn::make('wallet_balance')
                    ->label('Wallet')
                    ->money('INR')
                    ->sortable()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('total_earned')
                    ->label('Total Earned')
                    ->money('INR')
                    ->sortable(),
                
                
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'sub_admin' => 'Sub Admin',
                        'user' => 'User',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'suspended' => 'Suspended',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('to'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['to'], fn ($q) => $q->whereDate('created_at', '<=', $data['to']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View'),
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->color('primary'),
                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['status' => 'active']))
                        ->color('success')
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('suspend')
                        ->label('Suspend Selected')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['status' => 'suspended']))
                        ->color('danger')
                        ->requiresConfirmation(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }
}