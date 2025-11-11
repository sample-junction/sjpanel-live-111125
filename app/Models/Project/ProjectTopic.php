<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectTopic extends Model
{
    protected $fillable = [
        'id',
        'code',
        'name',
        'status',
        'order',
    ];
    public $timestamps = false;
}
