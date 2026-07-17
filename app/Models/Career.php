<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    protected $guarded = [];

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
