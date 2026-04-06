<?php

namespace App\Filament\Admin\Resources\CommissionLevelResource\Pages;

use App\Filament\Admin\Resources\CommissionLevelResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateCommissionLevel extends CreateRecord
{
    protected static string $resource = CommissionLevelResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Commission Level Created')
            ->body('The commission level has been created successfully.');
    }
}