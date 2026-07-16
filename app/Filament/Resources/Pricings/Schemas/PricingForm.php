<?php

namespace App\Filament\Resources\Pricings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PricingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Paket')
                    ->required()
                    ->placeholder('Contoh: Startup Premium'),

                TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->placeholder('Contoh: Rp 4.999.000 atau Hubungi Kami'),

                Select::make('period')
                    ->label('Periode Biaya')
                    ->options([
                        'project' => 'Per Project',
                        'month' => 'Per Bulan',
                        'year' => 'Per Tahun',
                    ])
                    ->default('project')
                    ->required()
                    ->native(false),

                Toggle::make('is_popular')
                    ->label('Paket Populer (Rekomendasi)')
                    ->default(false)
                    ->inline(false),

                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->rows(2)
                    ->columnSpanFull(),

                // Menggunakan Repeater untuk input daftar fitur secara dinamis
                Repeater::make('features')
                    ->label('Fitur / Benefit yang Didapat')
                    ->simple(
                        TextInput::make('feature')
                            ->placeholder('Contoh: Gratis Revisi 3x')
                            ->required()
                    )
                    ->addActionLabel('Tambah Fitur Baru')
                    ->columnSpanFull()
                    ->minItems(1),
            ]);
    }
}
