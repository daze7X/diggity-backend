<?php

namespace App\Filament\Resources\Portfolios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction; // Tambah aksi hapus satuan
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn; // Pastikan ini di-import
use Filament\Tables\Table;

class PortfoliosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Preview')
                    ->square() // Memaksa gambar jadi kotak rapi (atau pakai ->circular() kalau mau bulat)
                    ->size(50), // Ukuran pas, tidak kekecilan/kebesaran

                TextColumn::make('title')
                    ->label('Judul Project')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default biar gak menuh-menuhin tabel

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge() // Ubah kategori jadi badge estetik
                    ->color('primary') // Warna default ungu/biru khas Filament
                    ->sortable()
                    ->searchable(),

                TextColumn::make('client')
                    ->label('Klien')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('duration')
                    ->label('Durasi')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(), // Tombol hapus langsung di baris data
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
