<?php

namespace App\Filament\Resources\TalentServices\Pages;

use App\Filament\Resources\TalentServices\TalentServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTalentServices extends ListRecords
{
    protected static string $resource = TalentServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver(),
        ];
    }
}
