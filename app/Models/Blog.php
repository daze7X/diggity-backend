<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasSeo;

class Blog extends Model
{
    use HasFactory, HasSeo;

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
