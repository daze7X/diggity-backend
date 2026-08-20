<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AutoTranslateExistingData extends Command
{
    protected $signature = 'diggity:translate-all';
    protected $description = 'Sapu jagat menerjemahkan semua data existing yang bahasa Inggrisnya kosong';

    public function handle()
    {
        $models = [
            \App\Models\Product::class,
            \App\Models\Portfolio::class,
            \App\Models\Blog::class,
            \App\Models\Service::class,
            \App\Models\Course::class,
            \App\Models\Career::class,
        ];

        $translator = new GoogleTranslate('en', 'id');

        foreach ($models as $modelClass) {
            if (!class_exists($modelClass)) continue;
            
            $this->info("Memeriksa $modelClass...");
            $items = $modelClass::all();

            foreach ($items as $item) {
                $fields = $item->getTranslatableFields();
                $updated = false;

                foreach ($fields as $field) {
                    $enKey = 'en_' . $field;
                    $idValue = $item->getAttribute($field);
                    $enValue = $item->getTranslation($field, 'en');
                    
                    if (!empty(trim((string)$idValue)) && empty(trim((string)$enValue))) {
                        $this->line("Menerjemahkan [$field] ID: {$item->id}");
                        try {
                            $translated = $translator->translate($idValue);
                            $item->{$enKey} = $translated;
                            $updated = true;
                        } catch (\Exception $e) {
                            $this->error("Gagal menerjemahkan [$field] ID: {$item->id}. Error: " . $e->getMessage());
                        }
                    }
                }
                
                if ($updated) {
                    $item->save();
                }
            }
        }
        $this->info('Semua data lama berhasil diterjemahkan!');
    }
}
