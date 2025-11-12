<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class FroudUsers extends Model
{
    protected $fillable = [
        'id',
        'panellist_id',
        'project_id',
        'manager_id',
        'reason',
        'createdOn'

    ];
    public $timestamps = false;
}
