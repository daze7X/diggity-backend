<?php

namespace App\Filament\Resources\StaticPageSeos\Pages;

use App\Filament\Resources\StaticPageSeos\StaticPageSeoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStaticPageSeos extends ListRecords
{
    protected static string $resource = StaticPageSeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
