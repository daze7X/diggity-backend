<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasSeo;
use App\Traits\HasTranslations;
use App\Traits\LogsActivity;

class Service extends Model
{
    use HasSeo, HasTranslations, LogsActivity;

    protected $translatable = ['name', 'description'];
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'icon',
        'description',
    ];

    // Relasi: Setiap service pasti dimiliki oleh 1 kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}