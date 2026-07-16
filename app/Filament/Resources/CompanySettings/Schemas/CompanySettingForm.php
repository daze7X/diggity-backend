<?php

namespace App\Filament\Resources\CompanySettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompanySettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Agensi')
                    ->required(),

                TextInput::make('email')
                    ->label('Email Official')
                    ->email(),

                TextInput::make('whatsapp')
                    ->label('Nomor WhatsApp')
                    ->placeholder('Contoh: 628123456789'),

                Textarea::make('address')
                    ->label('Alamat Kantor')
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('instagram_url')
                    ->label('URL Instagram')
                    ->url(),

                TextInput::make('linkedin_url')
                    ->label('URL LinkedIn')
                    ->url(),
            ]);
    }
}
