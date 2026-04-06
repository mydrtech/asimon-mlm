<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CommissionLevelResource\Pages;
use App\Models\CommissionLevel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class CommissionLevelResource extends Resource
{
    protected static ?string $model = CommissionLevel::class;
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Commission Levels';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Commission Level Configuration')
                    ->schema([
                        Forms\Components\TextInput::make('level')
                            ->label('Level Number')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(50)
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Commission level (1 = direct referral, 2 = second level, etc.)'),
                        
                        Forms\Components\TextInput::make('percentage')
                            ->label('Commission Percentage (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(0.01)
                            ->required()
                            ->helperText('Percentage of amount to give as commission'),
                        
                        Forms\Components\TextInput::make('bonus_amount')
                            ->label('Bonus Amount (₹)')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Fixed bonus amount (if any)'),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Enable/disable this level'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('level')
                    ->label('Level')
                    ->numeric()
                    ->sortable()
                    ->color('primary')
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('percentage')
                    ->label('Commission %')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => $state . '%'),
                
                Tables\Columns\TextColumn::make('bonus_amount')
                    ->label('Bonus Amount')
                    ->money('INR')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('level', 'asc')
            ->reorderable('level')
            ->actions([
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
            'index' => Pages\ListCommissionLevels::route('/'),
            'create' => Pages\CreateCommissionLevel::route('/create'),
            'edit' => Pages\EditCommissionLevel::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}