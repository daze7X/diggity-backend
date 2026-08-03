<?php

namespace App\Filament\Resources\UserLicenses\Pages;

use App\Filament\Resources\UserLicenses\UserLicenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserLicense extends CreateRecord
{
    protected static string $resource = UserLicenseResource::class;
}
