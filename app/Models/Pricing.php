<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use App\Traits\LogsActivity;

class Pricing extends Model
{
    use HasTranslations, LogsActivity;

    protected $translatable = ['name', 'period', 'description', 'features'];

    protected $fillable = ['name', 'price', 'period', 'description', 'features', 'is_popular'];

    protected $casts = [
        'features' => 'array', // Supaya otomatis dikonversi jadi array PHP saat diakses
        'is_popular' => 'boolean',
    ];

    public function setIsPopularAttribute($value)
    {
        $this->attributes['is_popular'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }
}