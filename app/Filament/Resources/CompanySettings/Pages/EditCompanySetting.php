<?php

namespace App\Filament\Resources\CompanySettings\Pages;

use App\Filament\Resources\CompanySettings\CompanySettingResource;
use Filament\Resources\Pages\EditRecord;

class EditCompanySetting extends EditRecord
{
    protected static string $resource = CompanySettingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function getHeaderActions(): array
    {
        return [
            // Disabled delete action to protect settings record
        ];
    }
}
