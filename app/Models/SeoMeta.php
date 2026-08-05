<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    use HasFactory;

    protected $table = 'seo_meta';

    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'json_ld_schema',
    ];

    // No casts to keep raw JSON-LD schema string intact

    /**
     * Get the parent seoable model (morph).
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
