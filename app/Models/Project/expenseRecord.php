<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class expenseRecord extends Model
{
    protected $fillable = [
        'user_id',
        'source',
        'type',
        'point'
    ];
}
