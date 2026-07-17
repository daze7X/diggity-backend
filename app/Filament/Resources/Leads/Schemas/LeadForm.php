<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select; // Kita tambahkan Select component
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Calon Klien')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('phone')
                    ->label('Nomor Telepon/WA')
                    ->tel()
                    ->required()
                    ->maxLength(50),
                    
                TextInput::make('company')
                    ->label('Perusahaan')
                    ->maxLength(255),
                    
                TextInput::make('service')
                    ->label('Layanan yang Diminati')
                    ->maxLength(255),
                    
                Select::make('status')
                    ->label('Status Prospek')
                    ->options([
                        'new' => 'Baru Masuk',
                        'read' => 'Sudah Dibaca',
                        'contacted' => 'Sedang Dihubungi',
                        'deal' => 'Deal (Klien Resmi)',
                        'rejected' => 'Ditolak/Cancel',
                    ])
                    ->required()
                    ->default('new')
                    ->native(false), // Menggunakan UI dropdown Filament yang sleek

                Textarea::make('message')
                    ->label('Isi Pesan / Kebutuhan Project')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
            ]);
    }
}