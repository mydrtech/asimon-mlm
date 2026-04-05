<?php

namespace App\Filament\Admin\Resources\MlmSettingResource\Pages;

use App\Filament\Admin\Resources\MlmSettingResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateMlmSetting extends CreateRecord
{
    protected static string $resource = MlmSettingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('MLM Setting Created')
            ->body('The MLM configuration has been created successfully.');
    }
}