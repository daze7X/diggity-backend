<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->label('Pertanyaan')
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('answer')
                    ->label('Jawaban')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0)
                    ->helperText('Angka lebih kecil akan tampil lebih atas'),

                Toggle::make('is_published')
                    ->label('Terbitkan')
                    ->default(true)
                    ->inline(false),
            ]);
    }
}
