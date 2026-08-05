<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasSeo;
use App\Traits\HasTranslations;
use App\Traits\LogsActivity;

class Blog extends Model
{
    use HasFactory, HasSeo, HasTranslations, LogsActivity;

    protected $translatable = ['title', 'content'];

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'image',
        'meta_title',
        'meta_description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
