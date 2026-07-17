<?php

namespace App\Filament\Resources\Subscribers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->unique(table: 'subscribers', ignoreRecord: true),

                Select::make('status')
                    ->label('Status Berlangganan')
                    ->options([
                        'active' => 'Aktif (Menerima Email)',
                        'inactive' => 'Tidak Aktif (Unsubscribed)',
                    ])
                    ->required()
                    ->default('active')
                    ->native(false),
            ]);
    }
}
