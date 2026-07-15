<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\MarkdownEditor; // Kembali mewah
use Filament\Schemas\Schema;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->lazy()
                    ->afterStateUpdated(fn ($set, $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'portfolios', ignoreRecord: true),

                Select::make('category')
                    ->required()
                    ->options([
                        'App Builder Squad' => 'App Builder Squad',
                        'Brand Growth Division' => 'Brand Growth Division',
                        'Cloud Service Hub' => 'Cloud Service Hub',
                        'Digital Skill Lab' => 'Digital Skill Lab',
                    ]),

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