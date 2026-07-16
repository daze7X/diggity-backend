<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = ['name', 'email', 'whatsapp', 'address', 'instagram_url', 'linkedin_url'];
}
