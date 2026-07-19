<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_name')
                    ->label('Nama Klien')
                    ->required(),

                TextInput::make('company')
                    ->label('Perusahaan / Instansi')
                    ->placeholder('Contoh: CV Sinergi Cita Digital'),

                Select::make('rating')
                    ->label('Rating Bintang')
                    ->options([
                        5 => '⭐⭐⭐⭐⭐ (5)',
                        4 => '⭐⭐⭐⭐ (4)',
                        3 => '⭐⭐⭐ (3)',
                        2 => '⭐⭐ (2)',
                        1 => '⭐ (1)',
                    ])
                    ->default(5)
                    ->required()
                    ->native(false),

                FileUpload::make('avatar')
                    ->label('Foto Klien (Opsional)')
                    ->image()
                    ->disk('public')
                    ->directory('client-avatars')
                    ->avatar()
                    ->columnSpanFull(),

                Textarea::make('review')
                    ->label('Isi Testimoni')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
