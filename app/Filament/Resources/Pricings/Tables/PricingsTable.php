<?php

namespace App\Filament\Resources\Pricings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PricingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->searchable(),

                TextColumn::make('period')
                    ->label('Periode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'month' => 'info',
                        'year' => 'success',
                        'project' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'month' => 'Per Bulan',
                        'year' => 'Per Tahun',
                        'project' => 'Per Project',
                        default => $state,
                    }),

                IconColumn::make('is_popular')
                    ->label('Populer')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('features')
                    ->label('Jumlah Fitur')
                    ->formatStateUsing(fn ($state): string => (is_array($state) ? count($state) : 0).' Fitur'),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
