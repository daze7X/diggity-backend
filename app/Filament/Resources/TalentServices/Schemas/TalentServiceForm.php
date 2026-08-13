<?php

namespace App\Filament\Resources\TalentServices\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class TalentServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Nama Layanan / Judul')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('URL Slug')
                    ->required()
                    ->disabled() // Slug is set automatically (e.g. headhunting, outsourcing)
                    ->maxLength(255),

                TextInput::make('sub_title')
                    ->label('Sub-judul Banner')
                    ->maxLength(255)
                    ->placeholder('Misal: Pemetaan Kebutuhan Teknis'),

                MarkdownEditor::make('description')
                    ->label('Deskripsi Utama (Hero Section)')
                    ->columnSpanFull(),

                Repeater::make('process_tabs')
                    ->label('Alur Proses Layanan (Tabs)')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Tab')
                            ->required(),
                        TextInput::make('subtitle')
                            ->label('Sub-judul Langkah')
                            ->required(),
                        Textarea::make('content')
                            ->label('Deskripsi Langkah')
                            ->required()
                            ->rows(3),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),

                Repeater::make('faqs')
                    ->label('Pertanyaan Sering Diajukan (FAQ)')
                    ->schema([
                        TextInput::make('q')
                            ->label('Pertanyaan (Question)')
                            ->required(),
                        Textarea::make('a')
                            ->label('Jawaban (Answer)')
                            ->required()
                            ->rows(3),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['q'] ?? null),
            ]);
    }
}
