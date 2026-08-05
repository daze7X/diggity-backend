<?php

namespace App\Filament\Resources\StaticPageSeos\Pages;

use App\Filament\Resources\StaticPageSeos\StaticPageSeoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStaticPageSeo extends EditRecord
{
    protected static string $resource = StaticPageSeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
