<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Model;

class new_template extends Model
{
    
     
    protected $fillable = [
        'template_type',
        'template_name',
        'template_content',
        'email_subject',
        'url',
        'template_status',
        'user_id',
        'approve_id',
        'approval_email',
    ];

}
