<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class CompanySetting extends Model
{
    use HasTranslations;

    protected $translatable = ['philosophy_build', 'philosophy_grow', 'philosophy_scale', 'philosophy_empower', 'history_text_id', 'history_timeline'];

    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'address',
        'instagram_url',
        'linkedin_url',
        'discord_url',
        'telegram_url',
        // New columns
        'company_pt_name',
        'company_nib',
        'company_kbli',
        'philosophy_build',
        'philosophy_grow',
        'philosophy_scale',
        'philosophy_empower',
        'partner_logos',
        'history_timeline',
        'vision_id',
        'vision_en',
        'mission_id',
        'mission_en',
        'company_profile_pdf',
        'history_text_id',
        'history_text_en',
        'philosophy_build_en',
        'philosophy_grow_en',
        'philosophy_scale_en',
        'philosophy_empower_en'
    ];

    protected $casts = [
        'partner_logos' => 'array',
        'history_timeline' => 'array',
        'mission_id' => 'array',
        'mission_en' => 'array',
    ];
}

