<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPageSeo extends Model
{
    use HasFactory;

    protected $table = 'static_page_seo';

    protected $fillable = [
        'page_slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'json_ld_schema',
    ];

    // No casts to keep raw JSON-LD schema string intact
}
