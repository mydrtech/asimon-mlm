<?php

namespace App\Filament\Admin\Widgets;

use App\Models\WithdrawRequest;
use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Notifications\Notification;

class RecentWithdrawalsWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = '💸 Pending Withdrawal Requests';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                WithdrawRequest::where('status', 'pending')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.pan_number')
                    ->label('PAN')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('INR')
                    ->weight('bold')
                    ->color('danger'),
                Tables\Columns\TextColumn::make('method')
                    ->label('Method')
                    ->badge()
                    ->color('info'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger'  => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Requested')
                    ->dateTime('d M Y'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->user->decrement('wallet_balance', $record->amount);
                        Transaction::create([
                            'user_id' => $record->user_id,
                            'type'    => 'withdrawal',
                            'amount'  => $record->amount,
                            'status'  => 'completed',
                            'note'    => 'Withdrawal approved by admin',
                        ]);
                        $record->update(['status' => 'paid', 'processed_at' => now()]);
                        Notification::make()->title('✅ Approved!')->success()->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->user->increment('wallet_balance', $record->amount);
                        $record->update(['status' => 'rejected', 'processed_at' => now()]);
                        Notification::make()->title('❌ Rejected')->warning()->send();
                    }),
            ])
            ->paginated(false);
    }
}