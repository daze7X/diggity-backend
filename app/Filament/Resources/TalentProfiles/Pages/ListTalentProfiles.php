<?php

namespace App\Filament\Resources\TalentProfiles\Pages;

use App\Filament\Resources\TalentProfiles\TalentProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTalentProfiles extends ListRecords
{
    protected static string $resource = TalentProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
