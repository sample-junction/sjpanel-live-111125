<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $fillable = [
               'question_id',
               'answer',
               'user_id',
               'created_at',
               'updated_at',
               'status',
           ];
    public function question()
   {
       return $this->belongsTo(Question::class);
   }
}
