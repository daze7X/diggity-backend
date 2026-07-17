<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
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

                Select::make('role')
                    ->label('Role Akses')
                    ->options([
                        'admin' => 'Admin (Pengelola Konten)',
                        'super_admin' => 'Super Admin (Akses Penuh)',
                    ])
                    ->required()
                    ->default('admin')
                    ->native(false),

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
