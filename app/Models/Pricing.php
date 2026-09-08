<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasTranslations;
use App\Traits\LogsActivity;

class Pricing extends Model
{
    use HasTranslations, LogsActivity;

    protected $translatable = ['name', 'period', 'description', 'features', 'pricing_label', 'cta_text'];

    protected $fillable = [
        'product_id',
        'pricing_type',
        'currency',
        'name', 
        'price',
        'numeric_price',
        'period', 
        'minimum_quantity',
        'discount_percentage',
        'original_price',
        'annual_price',
        'sale_price',
        'pricing_label',
        'cta_text',
        'license_type',
        'is_free_trial',
        'is_enterprise',
        'contact_sales',
        'pricing_status',
        'description', 
        'features', 
        'is_popular'
    ];

    protected $casts = [
        'features' => 'array', 
        'is_popular' => 'boolean',
        'is_free_trial' => 'boolean',
        'is_enterprise' => 'boolean',
        'contact_sales' => 'boolean',
        'numeric_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'original_price' => 'decimal:2',
        'annual_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function setIsPopularAttribute($value)
    {
        $this->attributes['is_popular'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
