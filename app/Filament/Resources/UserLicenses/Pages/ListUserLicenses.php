<?php

namespace App\Filament\Resources\UserLicenses\Pages;

use App\Filament\Resources\UserLicenses\UserLicenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserLicenses extends ListRecords
{
    protected static string $resource = UserLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
