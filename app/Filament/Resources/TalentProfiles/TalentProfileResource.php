<?php

namespace App\Filament\Resources\TalentProfiles;

use App\Filament\Resources\TalentProfiles\Pages\CreateTalentProfile;
use App\Filament\Resources\TalentProfiles\Pages\EditTalentProfile;
use App\Filament\Resources\TalentProfiles\Pages\ListTalentProfiles;
use App\Filament\Resources\TalentProfiles\Schemas\TalentProfileForm;
use App\Filament\Resources\TalentProfiles\Tables\TalentProfilesTable;
use App\Models\TalentProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TalentProfileResource extends Resource
{
    protected static ?string $model = TalentProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TalentProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TalentProfilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTalentProfiles::route('/'),
            'create' => CreateTalentProfile::route('/create'),
            'edit' => EditTalentProfile::route('/{record}/edit'),
        ];
    }
}
