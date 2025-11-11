<?php

namespace App\Models\InviteCampaign;

use Illuminate\Database\Eloquent\Model;

class UnverifyEmail extends Model
{
    protected $table = 'unverify_emails';
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'branch_name',
        'email',
        'mobile',
        'reason',
        
    ];

    // protected $casts = [
    //     'validation_response' => 'array',
    // ];
}
