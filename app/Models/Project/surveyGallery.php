<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class surveyGallery extends Model
{
	protected $table = "surveygallery";
    protected $fillable = [
        'panelist_id',
        'path',
    ];
}
