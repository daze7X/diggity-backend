<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'address',
        'instagram_url',
        'linkedin_url',
        // New columns
        'company_pt_name',
        'company_nib',
        'company_kbli',
        'philosophy_build',
        'philosophy_grow',
        'philosophy_scale',
        'philosophy_empower',
        'partner_logos',
        'history_timeline'
    ];

    protected $casts = [
        'partner_logos' => 'array',
        'history_timeline' => 'array',
    ];
}
