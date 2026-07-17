<?php

namespace App\Filament\Resources\Careers\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CareerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Lowongan')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                TextInput::make('slug')
                    ->label('URL Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'careers', ignoreRecord: true),

                TextInput::make('department')
                    ->label('Departemen / Divisi')
                    ->maxLength(255)
                    ->placeholder('Misal: Engineering, Marketing'),

                Select::make('type')
                    ->label('Tipe Pekerjaan')
                    ->options([
                        'Full-time' => 'Penuh Waktu (Full-time)',
                        'Part-time' => 'Paruh Waktu (Part-time)',
                        'Contract' => 'Kontrak (Contract)',
                        'Internship' => 'Magang (Internship)',
                    ])
                    ->required()
                    ->native(false),

                Select::make('location')
                    ->label('Lokasi Kerja')
                    ->options([
                        'On-site' => 'On-site (Di Kantor)',
                        'Hybrid' => 'Hybrid (Gabungan)',
                        'Remote' => 'Remote (Jarak Jauh)',
                    ])
                    ->required()
                    ->native(false),

                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),

                MarkdownEditor::make('description')
                    ->label('Deskripsi Pekerjaan')
                    ->required()
                    ->columnSpanFull(),

                MarkdownEditor::make('requirements')
                    ->label('Persyaratan / Kualifikasi')
                    ->columnSpanFull(),
            ]);
    }
}
