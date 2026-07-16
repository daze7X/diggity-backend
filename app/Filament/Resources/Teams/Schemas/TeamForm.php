<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),

                TextInput::make('position')
                    ->label('Jabatan / Posisi')
                    ->placeholder('Contoh: Lead Developer')
                    ->required(),

                FileUpload::make('photo')
                    ->label('Foto Profil')
                    ->image()
                    ->directory('team-photos')
                    ->avatar() // Mengubah rasio jadi lingkaran/kotak pas untuk foto profil
                    ->columnSpanFull(),

                TextInput::make('linkedin_url')
                    ->label('Link LinkedIn (Opsional)')
                    ->url()
                    ->placeholder('https://linkedin.com/in/...'),
            ]);
    }
}
