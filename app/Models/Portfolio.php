<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'client',
        'duration',
        'technologies',
        'problem',
        'solution',
        'strategy',
        'execution',
        'result',
        'image',
        'gallery',
    ];

    protected $casts = [
        'technologies' => 'array',
        'gallery' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
