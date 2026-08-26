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

                \App\Filament\Resources\Support\TranslationForm::make([
                    'title' => 'text',
                    'sub_title' => 'text',
                    'description' => 'markdown',
                ]),

                \Filament\Schemas\Components\Section::make('English Translations - Arrays (Lokalisasi EN)')
                    ->description('Tambahkan terjemahan untuk Alur Proses dan FAQ dalam bahasa Inggris.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('en_process_tabs')
                            ->label('Alur Proses Layanan (English)')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Tab Title (English)')
                                    ->required(),
                                TextInput::make('subtitle')
                                    ->label('Step Subtitle (English)')
                                    ->required(),
                                Textarea::make('content')
                                    ->label('Step Description (English)')
                                    ->required()
                                    ->rows(3),
                            ])
                            ->columnSpanFull()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),

                        Repeater::make('en_faqs')
                            ->label('FAQ (English)')
                            ->schema([
                                TextInput::make('q')
                                    ->label('Question (English)')
                                    ->required(),
                                Textarea::make('a')
                                    ->label('Answer (English)')
                                    ->required()
                                    ->rows(3),
                            ])
                            ->columnSpanFull()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['q'] ?? null),
                    ]),
            ]);
    }
}
