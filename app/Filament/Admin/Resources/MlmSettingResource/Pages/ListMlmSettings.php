<?php

namespace App\Filament\Admin\Resources\MlmSettingResource\Pages;

use App\Filament\Admin\Resources\MlmSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMlmSettings extends ListRecords
{
    protected static string $resource = MlmSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New Setting')
                ->icon('heroicon-o-plus'),
        ];
    }
}