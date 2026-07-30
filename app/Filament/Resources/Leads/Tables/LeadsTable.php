<?php

namespace App\Filament\Resources\Leads\Tables;

use App\Models\Lead;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Prospek / Kontak')
                    ->weight('bold')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Lead $record): string => "Email: {$record->email} | WA: {$record->phone}" . ($record->company ? " | Perusahaan: {$record->company}" : "")),

                TextColumn::make('service')
                    ->label('Layanan')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'info',
                        'read' => 'warning',
                        'contacted' => 'primary',
                        'deal' => 'success',
                        'rejected' => 'danger',
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
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'new' => 'Baru Masuk',
                        'read' => 'Sudah Dibaca',
                        'contacted' => 'Sedang Dihubungi',
                        'deal' => 'Deal',
                        'rejected' => 'Batal',
                    ]),
                SelectFilter::make('service')
                    ->label('Filter Layanan')
                    ->options([
                        'App Builder Squad' => 'App Builder Squad',
                        'Brand Growth Division' => 'Brand Growth Division',
                        'Cloud & Server Squad' => 'Cloud & Server Squad',
                        'Digital Skill Lab' => 'Digital Skill Lab',
                    ]),
            ])
            ->actions([
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}