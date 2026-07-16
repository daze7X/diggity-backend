<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Pengguna')
                    ->required(),

                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    // Hanya wajib diisi saat membuat user baru, kalau edit boleh dikosongkan jika tidak mau ganti
                    ->required(fn ($livewire) => $livewire instanceof CreateRecord)
                    ->dehydrated(fn ($state) => filled($state)) // Hanya simpan ke DB jika diisi
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)) // Otomatis di-hash demi keamanan
                    ->placeholder('Kosongkan jika tidak ingin mengubah password'),
            ]);
    }
}
