<?php

namespace App\Filament\Resources\CompanySettings\Pages;

use App\Filament\Resources\CompanySettings\CompanySettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanySettings extends ListRecords
{
    protected static string $resource = CompanySettingResource::class;

    public function mount(): void
    {
        $record = \App\Models\CompanySetting::first();

        if (! $record) {
            $record = \App\Models\CompanySetting::create([
                'name' => 'Diggity Agency',
                'email' => 'hello@diggity.com',
                'whatsapp' => '628123456789',
                'address' => 'Tangerang, Indonesia',
            ]);
        }

        $this->redirect(CompanySettingResource::getUrl('edit', ['record' => $record]));
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
