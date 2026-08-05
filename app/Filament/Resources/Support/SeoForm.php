<?php

namespace App\Filament\Resources\Support;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\KeyValue;

class SeoForm
{
    public static function make(): Section
    {
        return Section::make('SEO & Metadata Settings')
            ->description('Configure dynamic search engine optimization tags, canonical URLs, and structured JSON-LD schemas.')
            ->relationship('seoMeta')
            ->collapsible()
            ->collapsed()
            ->schema([
                TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->placeholder('Leave blank to use default title')
                    ->maxLength(255),
                Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->placeholder('Leave blank to use default description')
                    ->rows(3)
                    ->maxLength(500),
                TextInput::make('meta_keywords')
                    ->label('Meta Keywords')
                    ->placeholder('e.g. cloud, software, diggity')
                    ->maxLength(255),
                TextInput::make('canonical_url')
                    ->label('Canonical URL')
                    ->placeholder('e.g. https://diggity.id/custom-url')
                    ->url()
                    ->maxLength(255),
                Textarea::make('json_ld_schema')
                    ->label('Structured JSON-LD Schema Data')
                    ->placeholder('{"@context": "https://schema.org", "@type": "Organization", "name": "Diggity"}')
                    ->rows(5)
                    ->columnSpanFull()
                    ->helperText('Masukkan data JSON-LD valid. Jangan menyertakan tag <script>.'),
            ]);
    }
}
