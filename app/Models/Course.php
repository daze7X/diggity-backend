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

class Course extends Model
{
    use HasFactory, HasSeo, HasTranslations, LogsActivity;

    protected $translatable = ['title', 'description', 'syllabus', 'instructor_title', 'instructor_bio'];

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'type',
        'description',
        'syllabus',
        'instructor_name',
        'instructor_title',
        'instructor_bio',
        'instructor_avatar',
        'price',
        'original_price',
        'duration',
        'total_students',
        'rating',
        'reviews_count',
        'is_active',
        'is_featured',
        'badge',
        'benefits',
        'image',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'benefits' => 'array',
    ];

    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }

    public function setIsFeaturedAttribute($value)
    {
        $this->attributes['is_featured'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('sort_order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'purchasable');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
