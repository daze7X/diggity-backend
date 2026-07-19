<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Proyek')
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

                        TextInput::make('client')
                            ->label('Nama Klien')
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('duration')
                            ->label('Durasi Proyek')
                            ->maxLength(255)
                            ->nullable(),

                        TagsInput::make('technologies')
                            ->placeholder('Tambah teknologi (Tekan Enter/Koma)')
                            ->required(),

                        FileUpload::make('image')
                            ->image()
                            ->disk('public')
                            ->directory('portfolios')
                            ->nullable(),
                    ]),

                Section::make('Case Study')
                    ->components([
                        MarkdownEditor::make('problem')
                            ->label('Masalah (Problem)')
                            ->required()
                            ->columnSpanFull(),

                        MarkdownEditor::make('strategy')
                            ->label('Strategi (Strategy)')
                            ->nullable()
                            ->columnSpanFull(),

                        MarkdownEditor::make('solution')
                            ->label('Solusi (Solution)')
                            ->required()
                            ->columnSpanFull(),

                        MarkdownEditor::make('execution')
                            ->label('Eksekusi (Execution)')
                            ->nullable()
                            ->columnSpanFull(),

                        MarkdownEditor::make('result')
                            ->label('Hasil (Result)')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
