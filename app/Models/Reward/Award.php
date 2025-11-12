<?php

namespace App\Models\Reward;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Award extends Model
{
    // use HasFactory;
    use SoftDeletes;

    protected $table = 'awards';

    protected $fillable = [
        'name',
        'status',
        'nomination_start',
        'nomination_end',
        'mail_template_id',

    ];

    protected $dates = ['deleted_at'];

}