<?php

namespace App\Models\Reward;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwardsMailTemplate extends Model
{
    // use HasFactory;
    // use SoftDeletes;

    protected $table = 'awards_mail_template';

    protected $fillable = [
        'template_name',
        'template_content',
        'email_subject',
        'created_by',
    ];

    // protected $dates = ['deleted_at'];

}