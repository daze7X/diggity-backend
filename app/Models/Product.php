<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Traits\HasSeo;
use App\Traits\HasTranslations;
use App\Traits\LogsActivity;

class Product extends Model
{
    use HasFactory, HasSeo, HasTranslations, LogsActivity;

    protected $translatable = ['name', 'description', 'license_info', 'features', 'benefits', 'use_cases', 'specifications', 'integrations', 'faq'];

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'price',
        'billing_period',
        'description',
        'features',
        'gallery',
        'license_info',
        'version',
        'file_path',
        'is_active',
        'is_popular',
        'meta_title',
        'meta_description',
        'benefits',
        'use_cases',
        'specifications',
        'integrations',
        'faq',
    ];

    protected $casts = [
        'features' => 'array',
        'gallery' => 'array',
        'benefits' => 'array',
        'use_cases' => 'array',
        'specifications' => 'array',
        'integrations' => 'array',
        'faq' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
    ];

    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }

    public function setIsPopularAttribute($value)
    {
        $this->attributes['is_popular'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function pricings(): HasMany
    {
        return $this->hasMany(Pricing::class);
    }

    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'purchasable');
    }
}
