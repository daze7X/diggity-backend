<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AutoTranslateFields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:auto {--model= : Specify a specific model class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically translates empty fields for models using HasTranslations trait via Google Translate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting auto-translation process...');

        $models = [];
        if ($this->option('model')) {
            $models = ['App\\Models\\' . $this->option('model')];
        } else {
            $files = File::allFiles(app_path('Models'));
            foreach ($files as $file) {
                $class = 'App\\Models\\' . $file->getFilenameWithoutExtension();
                if (class_exists($class)) {
                    $traits = class_uses_recursive($class);
                    if (in_array('App\\Traits\\HasTranslations', $traits)) {
                        $models[] = $class;
                    }
                }
            }
        }

        foreach ($models as $modelClass) {
            $this->info("Processing Model: {$modelClass}");
            $records = $modelClass::all();
            
            $bar = $this->output->createProgressBar(count($records));
            $bar->start();

            foreach ($records as $record) {
                $fields = $record->getTranslatableFields();
                foreach ($fields as $field) {
                    $existing = $record->getTranslation($field, 'en');
                    $original = $record->getRawOriginal($field);
                    
                    if (empty($existing) && !empty($original)) {
                        $record->{"en_{$field}"} = null;
                        $record->save();
                    }
                }
                $bar->advance();
            }
            $bar->finish();
            $this->newLine();
        }

        $this->info('Auto-translation completed!');
    }
}
