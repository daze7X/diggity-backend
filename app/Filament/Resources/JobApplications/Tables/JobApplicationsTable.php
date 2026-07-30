<?php

namespace App\Filament\Resources\JobApplications\Tables;

use App\Models\JobApplication;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Pelamar / Kontak')
                    ->weight('bold')
                    ->searchable()
                    ->sortable()
                    ->description(fn (JobApplication $record): string => "Email: {$record->email} | WhatsApp: {$record->phone}"),

                TextColumn::make('career.title')
                    ->label('Lowongan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'applied' => 'info',
                        'reviewed' => 'warning',
                        'interviewed' => 'primary',
                        'hired' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'applied' => 'Baru Masuk',
                        'reviewed' => 'Ditinjau',
                        'interviewed' => 'Wawancara',
                        'hired' => 'Diterima',
                        'rejected' => 'Ditolak',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Melamar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'applied' => 'Baru Masuk',
                        'reviewed' => 'Ditinjau',
                        'interviewed' => 'Wawancara',
                        'hired' => 'Diterima',
                        'rejected' => 'Ditolak',
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
