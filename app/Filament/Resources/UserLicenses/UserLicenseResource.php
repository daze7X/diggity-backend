<?php

namespace App\Filament\Resources\UserLicenses;

use App\Filament\Resources\UserLicenses\Pages\CreateUserLicense;
use App\Filament\Resources\UserLicenses\Pages\EditUserLicense;
use App\Filament\Resources\UserLicenses\Pages\ListUserLicenses;
use App\Filament\Resources\UserLicenses\Schemas\UserLicenseForm;
use App\Filament\Resources\UserLicenses\Tables\UserLicensesTable;
use App\Models\UserLicense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserLicenseResource extends Resource
{
    protected static ?string $model = UserLicense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'license_key';

    public static function form(Schema $schema): Schema
    {
        return UserLicenseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserLicensesTable::configure($table);
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
            'index' => ListUserLicenses::route('/'),
            'create' => CreateUserLicense::route('/create'),
            'edit' => EditUserLicense::route('/{record}/edit'),
        ];
    }
}
