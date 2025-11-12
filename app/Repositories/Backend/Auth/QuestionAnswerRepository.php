<?php

namespace App\Repositories\Backend\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Models\Auth\User;
use App\Models\Question\QuestionAnswer;
use App\Models\Question\Question;
/**
 * Class UserRepository.
 */
class QuestionAnswerRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return QuestionAnswer::class;
    }

    /**
     * Function Name : create question & answer
     * Created By : Priyanka Sharma(02-july-2024)
     * */
    public function create(array $data){
       return DB::transaction(function () use ($data) {
            $flag = '0';
            $questions = $data['question'];
            $answers = $data['answer'];            
            foreach ($questions as $key => $q) {
                // Save question
                $saveQuestion = Question::create([
                    'question' => $q,
                    'user_id' => auth()->user()->id,                 
                    'status' => 1, // Assuming 'status' is an integer field
                ]);
                if($saveQuestion){
                    // Save answer
                    $saveAnswer = QuestionAnswer::create([
                        'question_id' => $saveQuestion->id, // Use $saveQuestion->id to get the inserted question's ID
                        'answer' => $answers[$key],
                        'user_id' => auth()->user()->id,
                        'status' => 1, // Assuming 'status' is an integer field
                    ]);
                    if($saveQuestion){
                        $flag = 1;
                    }else{
                        $flag= '0';
                        // throw new GeneralException(__('exceptions.backend.access.users.role_needed_create'));
                        throw new GeneralException(__('Failed to save answer'));
                    }
                }else{
                    // throw new GeneralException(__('exceptions.backend.access.users.role_needed_create'));
                    throw new GeneralException(__('Failed to save Question'));
                }
            }
            if($flag == '1'){
                return $saveQuestion;
            }else{
                throw new GeneralException(__('Failed to save question answer'));
            }
        });
    }

    /***
     * Function Name : get all Questions
     * Created By : Priyanka Sharma(02-july-2024)
     * */
    public function getQuestions(){
        $answers = QuestionAnswer::join('questions', 'question_answers.question_id', '=', 'questions.id')
            ->join('users', 'users.id', '=', 'question_answers.user_id')
            ->select('questions.id as question_id','question_answers.answer','question_answers.created_at','questions.question as question','users.first_name as created_by')
            ->where('question_answers.status','1')->get();
        return $answers;
    }

    /***
     * Function Name : get  Questions detail
     * Created By : Priyanka Sharma(02-july-2024)
     * */
    public function getQuestionDetail($id){
        $question = Question::where('questions.status', 1)->with('answers')->where('questions.id',$id)        
            ->first();
        return $question;
    }

    /***
     * Function Name : update  Questions detail
     * Created By : Priyanka Sharma(02-july-2024)
     * */
    public function update(array $data,$id)
    {
        return DB::transaction(function () use ($data,$id) {
            $question = $data['question'];
            $answer = $data['answer'];
            $answer_id = $data['answer_id'];
            $existingQuestion = Question::findOrFail($id);
            $existingQuestion->update([
                'question' => $question,
                'user_id' => auth()->user()->id,
                'updated_at' => now(),
               // 'status' => 1, // Assuming 'status' is an integer field
            ]);
            $existingAnswer = QuestionAnswer::where('id', $answer_id)
                                           ->where('question_id', $id)
                                           ->firstOrFail();

            // Update the answer
            $existingAnswer->update([
                'answer' => $answer,
                'user_id' => auth()->user()->id,
                //'updated_at' => now(),
                //'status' => 1, // Assuming 'status' is an integer field
            ]);
            if($existingQuestion && $existingAnswer){
                return $existingQuestion;
            }else{
                throw new GeneralException(__('exceptions.backend.access.users.update_error'));
            }
        });
    }

    /***
     * Function Name : soft delete  Question with answer
     * Created By : Priyanka Sharma(02-july-2024)
     * */
    public function deleteQA($id)
    {
        return DB::transaction(function () use ($id) {
            $existingQuestion = Question::findOrFail($id);
            $existingQuestion->update([
               'status' => '0', // Assuming 'status' is an integer field
            ]);
            $existingAnswer = QuestionAnswer::where('question_id', $id)
                                           ->firstOrFail();

            // Update the answer
            $existingAnswer->update([
                'status' => '0',
            ]);
            if($existingQuestion && $existingAnswer){
                return $existingQuestion;
            }else{
                throw new GeneralException(__('exceptions.backend.access.users.update_error'));
            }
        });
    }
}