<?php

namespace App\Filament\Admin\Resources\MlmSettingResource\Pages;

use App\Filament\Admin\Resources\MlmSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditMlmSetting extends EditRecord
{
    protected static string $resource = MlmSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('MLM Setting Updated')
            ->body('The MLM configuration has been updated successfully.');
    }
}