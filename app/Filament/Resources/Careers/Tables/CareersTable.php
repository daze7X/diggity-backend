<?php

namespace App\Filament\Resources\Careers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CareersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Lowongan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department')
                    ->label('Departemen')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),

                TextColumn::make('created_at')
                    ->label('Tanggal Rilis')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
