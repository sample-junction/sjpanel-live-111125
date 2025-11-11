<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class StudyType extends Model
{
    protected $fillable = [
        'id',
        'code',
        'name',
        'description',
        'status',
        'order',
    ];
    public $timestamps = false;
}
