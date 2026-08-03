<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                TextInput::make('slug')
                    ->label('URL Slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('type')
                    ->label('Tipe Kategori')
                    ->required()
                    ->options([
                        'blog' => 'Insights (Blog/News)',
                        'service' => 'Solutions (Service)',
                        'product' => 'Products (Marketplace/SaaS)',
                        'academy' => 'Academy (LMS)',
                        'job_connect' => 'Job Connect',
                    ])
                    ->default('blog'),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ]);
    }
}