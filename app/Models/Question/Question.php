<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
           'question',
           'user_id',
           'created_at',
           'updated_at',
           'status',
       ];

    public function answers()
   {
       return $this->hasMany(QuestionAnswer::class, 'question_id', 'id');
   }
}
