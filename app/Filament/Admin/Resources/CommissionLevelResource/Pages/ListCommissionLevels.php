<?php

namespace App\Filament\Admin\Resources\CommissionLevelResource\Pages;

use App\Filament\Admin\Resources\CommissionLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommissionLevels extends ListRecords
{
    protected static string $resource = CommissionLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Commission Level')
                ->icon('heroicon-o-plus'),
        ];
    }
}