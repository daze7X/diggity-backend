<?php

namespace App\Filament\Resources\StaticPageSeos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\KeyValue;
use Filament\Schemas\Schema;

class StaticPageSeoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('page_slug')
                    ->label('Halaman Statis')
                    ->options([
                        'home' => 'Home Page (/)',
                        'about' => 'About Us (/about)',
                        'contact' => 'Contact Us (/contact)',
                        'solutions' => 'Solutions (/solutions)',
                        'insights' => 'Insights (/insights)',
                        'job-connect' => 'Job Connect (/job-connect)',
                        'products' => 'Products (/products)',
                        'academy' => 'Academy (/academy)',
                    ])
                    ->required()
                    ->unique(table: 'static_page_seo', ignoreRecord: true),
                TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->placeholder('Leave blank to use default')
                    ->maxLength(255),
                Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->placeholder('Leave blank to use default')
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull(),
                TextInput::make('meta_keywords')
                    ->label('Meta Keywords')
                    ->placeholder('e.g. diggity, software, corporate'),
                TextInput::make('canonical_url')
                    ->label('Canonical URL')
                    ->placeholder('e.g. https://diggity.id/')
                    ->url(),
                Textarea::make('json_ld_schema')
                    ->label('Structured JSON-LD Schema Data')
                    ->placeholder('{"@context": "https://schema.org", "@type": "Organization", "name": "Diggity"}')
                    ->rows(5)
                    ->columnSpanFull()
                    ->helperText('Masukkan data JSON-LD valid. Jangan menyertakan tag <script>.'),
            ]);
    }
}
