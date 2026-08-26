<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class TalentService extends Model
{
    use HasTranslations;

    public array $translatable = [
        'title',
        'sub_title',
        'description',
        'process_tabs',
        'faqs',
    ];
    protected $fillable = [
        'slug',
        'title',
        'sub_title',
        'description',
        'process_tabs',
        'faqs',
    ];

    protected $casts = [
        'process_tabs' => 'array',
        'faqs' => 'array',
    ];
}
