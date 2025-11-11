<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class InviteSentDetails extends Model
{
    protected $fillable = [
        'id',
        'project_id',
        'project_quota_id',
        'apace_project_code',
        'apace_project_quota_id',
        'user_ids',
        'created_at',
        'invitecnt',
        'reminder',
        'surveycnt'

    ];
    public $timestamps = false;
}
