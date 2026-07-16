<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'technologies',
        'problem',
        'solution',
        'image',
    ];

    protected $casts = [
        'technologies' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
