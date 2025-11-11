<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class SurveyStartCount extends Model
{
    protected $fillable = [
        'id',
        'start_count',
        'start_date',
        'createdOn',
        'updateOn'
    ];
    public $timestamps = false;
}
