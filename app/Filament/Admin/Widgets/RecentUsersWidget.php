<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentUsersWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = '🆕 Recent Registrations';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::where('role', 'user')
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone'),
                Tables\Columns\TextColumn::make('pan_number')
                    ->label('PAN')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('referrer.name')
                    ->label('Sponsored By')
                    ->default('—'),
                Tables\Columns\TextColumn::make('wallet_balance')
                    ->label('Wallet')
                    ->money('INR'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger'  => 'suspended',
                        'warning' => 'inactive',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}