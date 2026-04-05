<?php

namespace App\Filament\Resources\MlmSettingResource\Pages;

use App\Filament\Resources\MlmSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMlmSetting extends EditRecord
{
    protected static string $resource = MlmSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
