<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\WithdrawalResource\Pages;
use App\Models\WithdrawRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class WithdrawalResource extends Resource
{
    protected static ?string $model = WithdrawRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-rupee';
    protected static ?string $navigationLabel = 'Withdrawals';
    protected static ?string $navigationGroup = 'Financial';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User')
                    ->disabled(),
                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'paid' => 'Paid',
                    ]),
                Forms\Components\Textarea::make('admin_note')
                    ->label('Admin Note'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('INR'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update(['status' => 'approved']);
                        Notification::make()->success()->title('Approved')->send();
                    })
                    ->visible(fn ($record) => $record->status === 'pending'),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->action(function ($record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->warning()->title('Rejected')->send();
                    })
                    ->visible(fn ($record) => $record->status === 'pending'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWithdrawals::route('/'),
            'create' => Pages\CreateWithdrawal::route('/create'),
            'edit' => Pages\EditWithdrawal::route('/{record}/edit'),
        ];
    }
}