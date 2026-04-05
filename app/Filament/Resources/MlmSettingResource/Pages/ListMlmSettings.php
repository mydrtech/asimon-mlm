<?php

namespace App\Filament\Resources\MlmSettingResource\Pages;

use App\Filament\Resources\MlmSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMlmSettings extends ListRecords
{
    protected static string $resource = MlmSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
