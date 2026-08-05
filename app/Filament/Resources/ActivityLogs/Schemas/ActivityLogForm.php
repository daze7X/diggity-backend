<?php

namespace App\Filament\Resources\ActivityLogs\Schemas;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ActivityLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        TextInput::make('created_at')
                            ->label('Tanggal & Waktu')
                            ->disabled(),

                        TextInput::make('user_name')
                            ->label('Pelaku (Admin)')
                            ->state(fn ($record) => $record?->user?->name ?? 'System / Anonymous')
                            ->disabled(),

                        TextInput::make('action')
                            ->label('Aksi')
                            ->state(fn ($state) => $state ? ucfirst($state) : '')
                            ->disabled(),

                        TextInput::make('subject_type')
                            ->label('Tipe Modul')
                            ->state(fn ($record) => $record ? class_basename($record->subject_type) : '')
                            ->disabled(),

                        TextInput::make('subject_id')
                            ->label('ID Record')
                            ->disabled(),

                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),
                    ]),

                Textarea::make('user_agent')
                    ->label('Browser / User Agent')
                    ->rows(2)
                    ->columnSpanFull()
                    ->disabled(),

                Textarea::make('properties')
                    ->label('Detail Perubahan (Sebelum vs Sesudah)')
                    ->state(fn ($record) => $record && $record->properties ? json_encode($record->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : 'Tidak ada detail data.')
                    ->rows(12)
                    ->columnSpanFull()
                    ->disabled(),
            ]);
    }
}
