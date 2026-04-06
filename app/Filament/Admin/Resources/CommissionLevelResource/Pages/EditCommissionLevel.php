<?php

namespace App\Filament\Admin\Resources\CommissionLevelResource\Pages;

use App\Filament\Admin\Resources\CommissionLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditCommissionLevel extends EditRecord
{
    protected static string $resource = CommissionLevelResource::class;

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
            ->title('Commission Level Updated')
            ->body('The commission level has been updated successfully.');
    }
}