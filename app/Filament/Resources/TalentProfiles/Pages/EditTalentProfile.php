<?php

namespace App\Filament\Resources\TalentProfiles\Pages;

use App\Filament\Resources\TalentProfiles\TalentProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTalentProfile extends EditRecord
{
    protected static string $resource = TalentProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
