<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput; // Kembali mewah
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori Proyek')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->lazy()
                    ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'portfolios', ignoreRecord: true),

                TagsInput::make('technologies')
                    ->placeholder('Tambah teknologi (Tekan Enter/Koma)')
                    ->required(),

                MarkdownEditor::make('problem')
                    ->label('Case Study: Masalah')
                    ->required()
                    ->columnSpanFull(),

                MarkdownEditor::make('solution')
                    ->label('Case Study: Solusi')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->image()
                    ->directory('portfolios')
                    ->nullable(),
            ]);
    }
}
