<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class SjpanelResponserates extends Model
{
    protected $fillable = [
        'id',
        'response_rate',
        'createdOn',
        'updateOn'
    ];
    public $timestamps = false;
}
