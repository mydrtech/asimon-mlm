<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopEarnersWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = '🏆 Top Earners';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::where('role', 'user')
                    ->where('total_earned', '>', 0)
                    ->orderBy('total_earned', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Member')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('pan_number')
                    ->label('PAN')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('referrer.name')
                    ->label('Sponsored By')
                    ->default('—'),
                Tables\Columns\TextColumn::make('total_earned')
                    ->label('Total Earned')
                    ->money('INR')
                    ->weight('bold')
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('wallet_balance')
                    ->label('Wallet Balance')
                    ->money('INR'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('d M Y'),
            ])
            ->paginated(false);
    }
}