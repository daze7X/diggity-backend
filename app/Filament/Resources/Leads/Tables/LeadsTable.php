<?php

namespace App\Filament\Resources\Leads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction; // Tambah aksi hapus satuan
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn; // Opsional jika ingin ganti status langsung di tabel
use Filament\Tables\Table;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Prospek')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('No. Telepon')
                    ->searchable(),

                TextColumn::make('company')
                    ->label('Perusahaan')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('service')
                    ->label('Layanan')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge() // Mengubah teks biasa jadi badge estetik
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'info',         // Biru
                        'read' => 'warning',     // Kuning
                        'contacted' => 'primary', // Ungu/Biru Tua
                        'deal' => 'success',     // Hijau
                        'rejected' => 'danger',   // Merah
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Baru Masuk',
                        'read' => 'Sudah Dibaca',
                        'contacted' => 'Sedang Dihubungi',
                        'deal' => 'Deal',
                        'rejected' => 'Batal',
                        default => $state,
                    })
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i') // Format tanggal lebih manusiawi
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false), // Kita tampilkan biar tahu kapan pesan masuk

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Nanti bisa kita isi filter berdasarkan status di sini
            ])
            ->actions([ // Menggunakan ->actions() standar untuk baris tabel
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([ // Memindahkan Bulk Action ke tempat yang benar
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}