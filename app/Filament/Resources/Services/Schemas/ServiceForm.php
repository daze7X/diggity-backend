<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name', fn ($query) => $query->where('type', 'service'))
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

                Section::make('Cakupan & Paket Layanan (Dinamis)')
                    ->components([
                        TagsInput::make('sub_services')
                            ->label('Cakupan Layanan / Fitur Utama')
                            ->placeholder('Tambah cakupan...')
                            ->columnSpanFull(),

                        Repeater::make('plans')
                            ->label('Paket Estimasi Harga & Investasi')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Paket')
                                    ->required(),
                                TextInput::make('price')
                                    ->label('Estimasi Investasi / Harga')
                                    ->placeholder('Misal: Mulai Rp 5.000.000')
                                    ->required(),
                                Toggle::make('isPopular')
                                    ->label('Tandai sebagai Populer / Rekomendasi')
                                    ->default(false),
                                Textarea::make('description')
                                    ->label('Deskripsi Paket')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TagsInput::make('features')
                                    ->label('Fitur / Detail Cakupan Paket')
                                    ->placeholder('Tambah fitur...')
                                    ->columnSpanFull()
                                    ->required(),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Statistik & Teknologi (Dinamis)')
                    ->description('Isi bagian ini untuk menampilkan statistik dan stack teknologi yang relevan dengan layanan ini di halaman publik.')
                    ->components([
                        Repeater::make('stats')
                            ->label('Statistik Layanan')
                            ->helperText('Contoh: Label = "Proyek Selesai", Nilai = "200+"')
                            ->schema([
                                TextInput::make('label')
                                    ->label('Label Statistik')
                                    ->placeholder('Contoh: Proyek Selesai')
                                    ->required(),
                                TextInput::make('value')
                                    ->label('Nilai Statistik')
                                    ->placeholder('Contoh: 200+')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->maxItems(4)
                            ->defaultItems(0)
                            ->columnSpanFull(),

                        TagsInput::make('tech_stack')
                            ->label('Teknologi / Tools yang Digunakan')
                            ->placeholder('Contoh: Next.js, React, Laravel...')
                            ->helperText('Tambahkan tag teknologi yang relevan dengan layanan ini.')
                            ->columnSpanFull(),
                    ]),

                \App\Filament\Resources\Support\SeoForm::make(),
                \App\Filament\Resources\Support\TranslationForm::make([
                    'name' => 'text',
                    'description' => 'textarea',
                ]),
            ]);
    }
}
