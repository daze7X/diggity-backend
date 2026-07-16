<?php

namespace App\Filament\Resources\CompanySettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompanySettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Agensi'),

                TextColumn::make('email')
                    ->label('Email'),

                TextColumn::make('whatsapp')
                    ->label('WhatsApp'),
            ])
            ->actions([EditAction::make()]); // Hanya izinkan edit karena ini konfigurasi global
    }
}
