<?php

namespace App\Filament\Resources\UserLicenses\Pages;

use App\Filament\Resources\UserLicenses\UserLicenseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserLicense extends EditRecord
{
    protected static string $resource = UserLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
