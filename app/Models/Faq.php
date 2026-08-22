<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use App\Traits\LogsActivity;

class Faq extends Model
{
    use HasTranslations, LogsActivity;

    protected $translatable = ['question', 'answer'];

    protected $fillable = ['question', 'answer', 'is_published', 'order'];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function setIsPublishedAttribute($value)
    {
        $this->attributes['is_published'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }
}