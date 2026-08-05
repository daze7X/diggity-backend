<?php

namespace App\Filament\Resources\Support;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;

class TranslationForm
{
    public static function make(array $fields): Section
    {
        $schema = [];
        foreach ($fields as $field => $type) {
            $label = ucfirst(str_replace('_', ' ', $field)) . ' (English)';
            $name = 'en_' . $field;
            
            if ($type === 'text') {
                $schema[] = TextInput::make($name)
                    ->label($label)
                    ->maxLength(255);
            } else if ($type === 'textarea') {
                $schema[] = Textarea::make($name)
                    ->label($label)
                    ->rows(3);
            } else if ($type === 'markdown') {
                $schema[] = MarkdownEditor::make($name)
                    ->label($label)
                    ->columnSpanFull();
            } else if ($type === 'richeditor') {
                $schema[] = RichEditor::make($name)
                    ->label($label)
                    ->columnSpanFull();
            }
        }

        return Section::make('English Translations (Lokalisasi EN)')
            ->description('Tambahkan versi bahasa Inggris untuk konten dinamis ini')
            ->collapsible()
            ->collapsed()
            ->schema($schema);
    }
}
