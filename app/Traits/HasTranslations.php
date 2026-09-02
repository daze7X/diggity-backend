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
        if ($this->relationLoaded('translations')) {
            $translation = $this->translations->where('locale', $locale)->where('field', $field)->first();
        } else {
            $translation = $this->translations()->where('locale', $locale)->where('field', $field)->first();
        }
        return $translation?->content;
    }

    /**
     * Save/update a translation value.
     */
    public function saveTranslation(string $locale, string $field, $value): void
    {
        $isEmpty = is_null($value) || (is_string($value) && trim($value) === '') || (is_array($value) && empty($value));
        
        if ($isEmpty) {
            $this->translations()->where('locale', $locale)->where('field', $field)->delete();
            return;
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        $this->translations()->updateOrCreate(
            ['locale' => $locale, 'field' => $field],
            ['content' => $value]
        );
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        $translatableFields = $this->getTranslatableFields();
        $currentLocale = App::getLocale();

        if ($currentLocale !== 'id' && in_array($key, $translatableFields)) {
            if (!$this->relationLoaded('translations')) {
                $this->load('translations');
            }
            $translated = $this->getTranslation($key, $currentLocale);
            
            if (!is_null($translated) && trim($translated) !== '') {
                if (is_array($value) && is_string($translated)) {
                    $decoded = json_decode($translated, true);
                    return is_array($decoded) ? $decoded : $value;
                }
                return $translated;
            }
        }
        return $value;
    }

    protected array $tempTranslations = [];

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

    public function __get($key)
    {
        if (is_string($key) && str_starts_with($key, 'en_')) {
            $field = substr($key, 3);
            if (in_array($field, $this->getTranslatableFields())) {
                $translated = $this->getTranslation($field, 'en');
                $originalValue = parent::getAttribute($field);
                
                if (is_array($originalValue) && is_string($translated)) {
                    $decoded = json_decode($translated, true);
                    return is_array($decoded) ? $decoded : [];
                }
                
                return $translated;
            }
        }
        return parent::__get($key);
    }

    public function setAttribute($key, $value)
    {
        if (is_string($key) && str_starts_with($key, 'en_')) {
            $field = substr($key, 3);
            if (in_array($field, $this->getTranslatableFields())) {
                $originalValue = parent::getAttribute($field);
                $isEmpty = is_null($value) || (is_string($value) && trim($value) === '') || (is_array($value) && empty($value));

                if ($isEmpty) {
                    if (!empty($originalValue)) {
                        try {
                            if (is_array($originalValue)) {
                                $translateRecursive = function($data) use (&$translateRecursive) {
                                    if (is_string($data)) {
                                        return \Stichoza\GoogleTranslate\GoogleTranslate::trans($data, 'en', 'id');
                                    }
                                    if (is_array($data)) {
                                        $translated = [];
                                        foreach ($data as $k => $v) {
                                            $translated[$k] = $translateRecursive($v);
                                        }
                                        return $translated;
                                    }
                                    return $data;
                                };
                                $value = $translateRecursive($originalValue);
                            } else {
                                $value = is_string($originalValue) ? \Stichoza\GoogleTranslate\GoogleTranslate::trans($originalValue, 'en', 'id') : $originalValue;
                            }
                        } catch (\Exception $e) {
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
                        if (is_array($attributes[$field]) && is_string($translated)) {
                            $decoded = json_decode($translated, true);
                            $attributes[$field] = is_array($decoded) ? $decoded : $attributes[$field];
                        } else {
                            $attributes[$field] = $translated;
                        }
                    }
                }
            }
        }
        return $attributes;
    }

    public function getTranslatableFields(): array
    {
        return $this->translatable ?? [
            'title', 'name', 'content', 'description', 'requirements', 
            'problem', 'solution', 'strategy', 'execution', 'result'
        ];
    }

    public function getFillable()
    {
        $fillable = parent::getFillable();
        foreach ($this->getTranslatableFields() as $field) {
            $fillable[] = 'en_' . $field;
        }
        return $fillable;
    }
}

