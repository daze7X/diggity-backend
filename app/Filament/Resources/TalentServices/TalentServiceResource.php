<?php

namespace App\Filament\Resources\TalentServices;

use App\Filament\Resources\TalentServices\Pages\ListTalentServices;
use App\Filament\Resources\TalentServices\Schemas\TalentServiceForm;
use App\Filament\Resources\TalentServices\Tables\TalentServicesTable;
use App\Models\TalentService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TalentServiceResource extends Resource
{
    protected static ?string $model = TalentService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|\UnitEnum|null $navigationGroup = 'Inquiries & Leads';

    protected static ?string $navigationLabel = 'B2B Talent Services';

    protected static ?string $pluralLabel = 'B2B Talent Services';

    public static function form(Schema $schema): Schema
    {
        return TalentServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TalentServicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTalentServices::route('/'),
        ];
    }
}
