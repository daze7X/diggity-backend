<?php

namespace App\Traits;

use App\Models\Translation;
use Illuminate\Support\Facades\App;

trait HasTranslations
{
    /**
     * Get all of the model's translations.
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Get a translation value for a field and locale.
     */
    public function getTranslation(string $field, string $locale): ?string
    {
        // Use eager-loaded collection or fall back to query if not loaded
        if ($this->relationLoaded('translations')) {
            $translation = $this->translations
                ->where('locale', $locale)
                ->where('field', $field)
                ->first();
        } else {
            $translation = $this->translations()
                ->where('locale', $locale)
                ->where('field', $field)
                ->first();
        }

        return $translation?->content;
    }

    /**
     * Save/update a translation value.
     */
    public function saveTranslation(string $locale, string $field, ?string $value): void
    {
        if (is_null($value) || trim($value) === '') {
            $this->translations()
                ->where('locale', $locale)
                ->where('field', $field)
                ->delete();
            return;
        }

        $this->translations()->updateOrCreate(
            ['locale' => $locale, 'field' => $field],
            ['content' => $value]
        );
    }

    /**
     * Override Eloquent's getAttribute method to transparently swap 
     * attribute values when the active locale is not 'id' (default).
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        // Only translate specific string/text fields
        $translatableFields = $this->getTranslatableFields();
        $currentLocale = App::getLocale();

        if ($currentLocale !== 'id' && in_array($key, $translatableFields)) {
            // Eager load translations relation to prevent N+1 queries if we are serializing arrays
            if (!$this->relationLoaded('translations')) {
                $this->load('translations');
            }
            
            $translated = $this->getTranslation($key, $currentLocale);
            if (!is_null($translated) && trim($translated) !== '') {
                return $translated;
            }
        }

        return $value;
    }

    /**
     * Temporal storage for unsaved translations during record creation.
     */
    protected array $tempTranslations = [];

    /**
     * Boot the trait to hook into model saving lifecycle.
     */
    public static function bootHasTranslations()
    {
        static::saved(function ($model) {
            if (isset($model->tempTranslations) && !empty($model->tempTranslations)) {
                foreach ($model->tempTranslations as $field => $value) {
                    $model->saveTranslation('en', $field, $value);
                }
                $model->tempTranslations = [];
            }
        });
    }

    /**
     * Magic getter to read en_ attributes.
     */
    public function __get($key)
    {
        if (is_string($key) && str_starts_with($key, 'en_')) {
            $field = substr($key, 3);
            if (in_array($field, $this->getTranslatableFields())) {
                return $this->getTranslation($field, 'en');
            }
        }
        return parent::__get($key);
    }

    /**
     * Override setAttribute to write en_ virtual attributes.
     */
    public function setAttribute($key, $value)
    {
        if (is_string($key) && str_starts_with($key, 'en_')) {
            $field = substr($key, 3);
            if (in_array($field, $this->getTranslatableFields())) {
                
                // Jika input bahasa Inggris kosong, terjemahkan otomatis dari bahasa Indonesia
                if (is_null($value) || trim($value) === '') {
                    $originalValue = $this->getAttribute($field);
                    if (!is_null($originalValue) && trim($originalValue) !== '') {
                        try {
                            $value = \Stichoza\GoogleTranslate\GoogleTranslate::trans($originalValue, 'en', 'id');
                        } catch (\Exception $e) {
                            // Biarkan kosong jika gagal
                            $value = null;
                        }
                    }
                }

                if (!$this->exists) {
                    $this->tempTranslations[$field] = $value;
                } else {
                    $this->saveTranslation('en', $field, $value);
                }
                return $this;
            }
        }
        return parent::setAttribute($key, $value);
    }

    /**
     * Override toArray to ensure translated fields are serialized in JSON responses.
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        $translatableFields = $this->getTranslatableFields();
        $currentLocale = App::getLocale();

        if ($currentLocale !== 'id') {
            if (!$this->relationLoaded('translations')) {
                $this->load('translations');
            }

            foreach ($translatableFields as $field) {
                if (array_key_exists($field, $attributes)) {
                    $translated = $this->getTranslation($field, $currentLocale);
                    if (!is_null($translated) && trim($translated) !== '') {
                        $attributes[$field] = $translated;
                    }
                }
            }
        }

        return $attributes;
    }

    /**
     * Define which attributes are translatable in the model.
     * Fallback to a default set or override in model.
     */
    public function getTranslatableFields(): array
    {
        return $this->translatable ?? [
            'title', 'name', 'content', 'description', 'requirements', 
            'problem', 'solution', 'strategy', 'execution', 'result'
        ];
    }

    /**
     * Override getFillable to dynamically allow en_ prefixed fields.
     */
    public function getFillable()
    {
        $fillable = parent::getFillable();
        foreach ($this->getTranslatableFields() as $field) {
            $fillable[] = 'en_' . $field;
        }
        return $fillable;
    }
}
