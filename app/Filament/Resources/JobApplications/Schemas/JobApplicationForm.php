<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('career_id')
                    ->relationship('career', 'title')
                    ->label('Lowongan Pekerjaan')
                    ->required()
                    ->native(false),

                TextInput::make('name')
                    ->label('Nama Pelamar')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Nomor Telepon/WA')
                    ->tel()
                    ->required()
                    ->maxLength(50),

                FileUpload::make('cv_path')
                    ->label('Unggah CV (PDF)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('cvs')
                    ->required(),

                Select::make('status')
                    ->label('Status Lamaran')
                    ->options([
                        'applied' => 'Baru Masuk (Applied)',
                        'reviewed' => 'Sedang Ditinjau (Reviewed)',
                        'interviewed' => 'Wawancara (Interviewed)',
                        'rejected' => 'Ditolak (Rejected)',
                        'hired' => 'Diterima (Hired)',
                    ])
                    ->required()
                    ->default('applied')
                    ->native(false),

                Textarea::make('cover_letter')
                    ->label('Surat Lamaran / Catatan Tambahan')
                    ->rows(5)
                    ->columnSpanFull(),
            ]);
    }
}
