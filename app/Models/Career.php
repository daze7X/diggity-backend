<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
