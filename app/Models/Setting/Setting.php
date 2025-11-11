<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'id',
        'key',
        'value'
    ];
    public $timestamps = false;
}
