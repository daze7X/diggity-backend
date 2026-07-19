<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor; // MarkdownEditor kembali aktif aman!
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori Artikel')
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
                    ->unique(table: 'blogs', ignoreRecord: true),

                MarkdownEditor::make('content') // Editor estetik untuk isi artikel
                    ->label('Isi Artikel')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Gambar Utama')
                    ->image()
                    ->disk('public')
                    ->directory('blogs')
                    ->nullable(),

                TextInput::make('meta_title')
                    ->label('Meta Title (SEO)')
                    ->maxLength(255),

                Textarea::make('meta_description')
                    ->label('Meta Description (SEO)')
                    ->maxLength(160)
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
