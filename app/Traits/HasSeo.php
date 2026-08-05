<?php

namespace App\Traits;

use App\Models\SeoMeta;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

trait HasSeo
{
    /**
     * Boot the trait to handle automatic cascades on delete.
     */
    protected static function bootHasSeo(): void
    {
        static::deleting(function ($model) {
            $model->seoMeta()->delete();
        });
    }

    /**
     * Get the model's polymorphic SEO metadata.
     */
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    /**
     * Get the SEO meta title with fallback.
     */
    public function getSeoTitle(): string
    {
        return $this->seoMeta?->meta_title 
            ?? $this->meta_title 
            ?? $this->title 
            ?? $this->name 
            ?? '';
    }

    /**
     * Get the SEO meta description with fallback.
     */
    public function getSeoDescription(): string
    {
        $description = $this->seoMeta?->meta_description 
            ?? $this->meta_description 
            ?? $this->description 
            ?? $this->content 
            ?? '';

        return Str::limit(strip_tags($description), 160);
    }

    /**
     * Get the SEO meta keywords.
     */
    public function getSeoKeywords(): string
    {
        return $this->seoMeta?->meta_keywords ?? '';
    }

    /**
     * Get the canonical URL.
     */
    public function getSeoCanonical(): string
    {
        return $this->seoMeta?->canonical_url ?? '';
    }

    /**
     * Get the JSON-LD Schema.
     */
    public function getSeoSchema(): ?array
    {
        return $this->seoMeta?->json_ld_schema;
    }
}
