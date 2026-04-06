<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Transactions';
    protected static ?string $navigationGroup = 'Financial';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Transaction Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        
                        Forms\Components\Select::make('from_user_id')
                            ->label('From User')
                            ->relationship('fromUser', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        
                        Forms\Components\Select::make('type')
                            ->label('Transaction Type')
                            ->options([
                                'commission' => 'Commission',
                                'bonus' => 'Bonus',
                                'withdrawal' => 'Withdrawal',
                                'deposit' => 'Deposit',
                                'refund' => 'Refund',
                            ])
                            ->required(),
                        
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount (₹)')
                            ->numeric()
                            ->required()
                            ->prefix('₹'),
                        
                        Forms\Components\TextInput::make('level')
                            ->label('Level')
                            ->numeric()
                            ->nullable(),
                        
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'completed' => 'Completed',
                                'failed' => 'Failed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        
                        Forms\Components\Textarea::make('note')
                            ->label('Note')
                            ->maxLength(65535)
                            ->columnSpanFull(),
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
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('fromUser.name')
                    ->label('From User')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('-'),
                
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'commission' => 'success',
                        'bonus' => 'info',
                        'withdrawal' => 'danger',
                        'deposit' => 'primary',
                        'refund' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('INR')
                    ->sortable()
                    ->color(fn (Transaction $record): string => 
                        $record->type === 'withdrawal' ? 'danger' : 'success'
                    ),
                
                Tables\Columns\TextColumn::make('level')
                    ->label('Level')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('-'),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        'cancelled' => 'secondary',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('note')
                    ->label('Note')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'commission' => 'Commission',
                        'bonus' => 'Bonus',
                        'withdrawal' => 'Withdrawal',
                        'deposit' => 'Deposit',
                        'refund' => 'Refund',
                    ]),
                
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                    ]),
                
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\Filter::make('amount_range')
                    ->form([
                        Forms\Components\TextInput::make('min_amount')
                            ->label('Min Amount')
                            ->numeric()
                            ->prefix('₹'),
                        Forms\Components\TextInput::make('max_amount')
                            ->label('Max Amount')
                            ->numeric()
                            ->prefix('₹'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['min_amount'], fn ($q) => $q->where('amount', '>=', $data['min_amount']))
                            ->when($data['max_amount'], fn ($q) => $q->where('amount', '<=', $data['max_amount']));
                    }),
                
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
                Tables\Actions\Action::make('mark_completed')
                    ->label('Mark Completed')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Transaction $record) => $record->status === 'pending')
                    ->action(function (Transaction $record) {
                        $record->update(['status' => 'completed']);
                        Notification::make()
                            ->success()
                            ->title('Transaction Updated')
                            ->body('Transaction marked as completed.')
                            ->send();
                    }),
                Tables\Actions\Action::make('mark_failed')
                    ->label('Mark Failed')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Transaction $record) => $record->status === 'pending')
                    ->action(function (Transaction $record) {
                        $record->update(['status' => 'failed']);
                        Notification::make()
                            ->warning()
                            ->title('Transaction Updated')
                            ->body('Transaction marked as failed.')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('bulk_complete')
                        ->label('Mark Selected as Completed')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'completed']))
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}