<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori')
                    ->required()
                    ->native(false), // Dropdown UI Filament yang premium

                TextInput::make('name')
                    ->label('Nama Layanan')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state ?? ''))),

                TextInput::make('slug')
                    ->label('URL Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'services', ignoreRecord: true),

                TextInput::make('icon')
                    ->label('Icon Class (misal: heroicon-o-cpu)')
                    ->maxLength(255)
                    ->nullable(),

                Textarea::make('description')
                    ->label('Deskripsi Layanan')
                    ->rows(5)
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }
}
