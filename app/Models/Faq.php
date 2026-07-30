<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['question', 'answer', 'is_published', 'order'];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function setIsPublishedAttribute($value)
    {
        $this->attributes['is_published'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }
}