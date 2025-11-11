<?php

namespace App\Models\Consent;

use Illuminate\Database\Eloquent\Model;

class ConsentLog extends Model
{
    protected $fillable = [
       'consent_type',
        'consent_text',
        'user_id'
    ];
}
