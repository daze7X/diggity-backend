<?php

namespace App\Filament\Resources\StaticPageSeos;

use App\Filament\Resources\StaticPageSeos\Pages\CreateStaticPageSeo;
use App\Filament\Resources\StaticPageSeos\Pages\EditStaticPageSeo;
use App\Filament\Resources\StaticPageSeos\Pages\ListStaticPageSeos;
use App\Filament\Resources\StaticPageSeos\Schemas\StaticPageSeoForm;
use App\Filament\Resources\StaticPageSeos\Tables\StaticPageSeosTable;
use App\Models\StaticPageSeo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StaticPageSeoResource extends Resource
{
    protected static ?string $model = StaticPageSeo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static string|\UnitEnum|null $navigationGroup = 'Settings & System';

    protected static ?string $recordTitleAttribute = 'page_slug';

    public static function form(Schema $schema): Schema
    {
        return StaticPageSeoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StaticPageSeosTable::configure($table);
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
            'index' => ListStaticPageSeos::route('/'),
            'create' => CreateStaticPageSeo::route('/create'),
            'edit' => EditStaticPageSeo::route('/{record}/edit'),
        ];
    }
}
