<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'online_course',
                        'success' => 'bootcamp',
                        'warning' => 'learning_path',
                        'danger' => 'e_book',
                        'info' => fn ($state) => in_array($state, ['webinar', 'workshop']),
                        'gray' => fn ($state) => in_array($state, ['corporate_training', 'certification', 'scholarship']),
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'online_course' => 'Online Course',
                        'bootcamp' => 'Bootcamp',
                        'learning_path' => 'Learning Path',
                        'e_book' => 'E-Book',
                        'webinar' => 'Webinar',
                        'workshop' => 'Workshop',
                        'corporate_training' => 'Corporate Training',
                        'certification' => 'Certification',
                        'scholarship' => 'Scholarship',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('badge')
                    ->label('Promo Badge')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('instructor_name')
                    ->searchable(),
                TextColumn::make('instructor_title')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')
                    ->money('IDR', locale: 'id') // Format Rp sesuai rupiah Indonesia
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->boolean(),
                ImageColumn::make('image')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('meta_title')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
