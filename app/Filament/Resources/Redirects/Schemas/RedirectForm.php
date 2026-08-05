<?php

namespace App\Filament\Resources\Redirects\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class RedirectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('from_path')
                    ->label('Dari Path (Old URL)')
                    ->placeholder('/layanan-kami')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'redirects', ignoreRecord: true),
                TextInput::make('to_path')
                    ->label('Ke Path/URL (New URL)')
                    ->placeholder('/solutions')
                    ->required()
                    ->maxLength(500),
                Select::make('status_code')
                    ->label('Tipe Pengalihan')
                    ->options([
                        301 => '301 - Permanent Redirect',
                        302 => '302 - Temporary Redirect',
                    ])
                    ->default(301)
                    ->required()
                    ->native(false),
            ]);
    }
}
