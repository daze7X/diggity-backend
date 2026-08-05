<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name', fn ($query) => $query->where('type', 'product')),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('sku')
                    ->label('SKU'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('billing_period')
                    ->required()
                    ->default('one_time'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('features'),
                TextInput::make('gallery'),
                Textarea::make('license_info')
                    ->columnSpanFull(),
                TextInput::make('version')
                    ->default('1.0.0'),
                TextInput::make('file_path'),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_popular')
                    ->required(),
                \App\Filament\Resources\Support\SeoForm::make(),
            ]);
    }
}
