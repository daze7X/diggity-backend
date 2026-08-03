<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'skills',
        'portfolio_links',
        'resume_path',
        'experience_years',
        'description',
        'status',
    ];

    protected $casts = [
        'skills' => 'array',
        'portfolio_links' => 'array',
        'experience_years' => 'integer',
    ];
}
