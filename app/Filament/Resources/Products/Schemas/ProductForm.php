<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
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
                    ->prefix('Rp'),
                TextInput::make('billing_period')
                    ->required()
                    ->default('one_time')
                    ->placeholder('one_time, monthly, or yearly'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TagsInput::make('features')
                    ->label('Key Features')
                    ->placeholder('Tulis fitur lalu tekan Enter...')
                    ->columnSpanFull(),
                FileUpload::make('gallery')
                    ->label('Preview Screenshots (Gallery)')
                    ->directory('products')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->columnSpanFull(),
                Textarea::make('license_info')
                    ->columnSpanFull(),
                TextInput::make('version')
                    ->default('1.0.0'),
                FileUpload::make('file_path')
                    ->label('Downloadable File (.zip, .pdf)')
                    ->directory('product_files'),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_popular')
                    ->required(),
                \App\Filament\Resources\Support\SeoForm::make(),
                \App\Filament\Resources\Support\TranslationForm::make([
                    'name' => 'text',
                    'description' => 'textarea',
                    'license_info' => 'textarea',
                ]),
            ]);
    }
}
