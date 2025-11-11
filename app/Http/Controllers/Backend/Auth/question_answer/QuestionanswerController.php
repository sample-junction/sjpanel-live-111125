<?php

namespace App\Http\Controllers\Backend\Auth\question_answer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question\QuestionAnswer;
use App\Models\Question\Question;
use Illuminate\Support\Facades\DB;
use App\Repositories\Backend\Auth\QuestionAnswerRepository;
use Illuminate\Validation\Rule;

class QuestionanswerController extends Controller
{
    
    /**
     * @var QuestionAnswerRepository
     */
    protected $questionAnswerRepository;

    /**
     * QuestionanswerController constructor.
     *
     * @param QuestionAnswerRepository $questionAnswerRepository
     */
    public function __construct(QuestionAnswerRepository $questionAnswerRepository)
    {
        $this->questionAnswerRepository = $questionAnswerRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = $this->questionAnswerRepository->getQuestions();
        return view("backend.auth.question_answer.index")
                   ->with("answers", $answers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.auth.question_answer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /*   $validatedData = $request->validate([
              'question.*' => 'required|string|max:255|unique:questions,question',
              'answer.*' => 'required|string',
          ], [
              'question.*.unique' => 'This question is already exist.',
              'question.*.required' => 'The question field is required.',
              'answer.*.required' => 'The answer field is required.',
          ]);*/
        $validatedData = $request->validate([
            'question.*' => [
                'required',
                'string',
                //'max:255',
                'unique:questions,question',
                new \App\Rules\NotNumericOrSpecialChars,
            ],
            'answer.*' => 'required|string',
        ], [
            'question.*.unique' => 'This question is already exist.',
            'question.*.max' => 'The question may not be greater than :max characters.',
            'question.*.NotNumericOrSpecialChars' => 'The question must contain at least one alphabetic character.',
            'question.*.required' => 'The question field is required.',
            'answer.*.required' => 'The answer field is required.',
        ]);
       $this->questionAnswerRepository->create(
                    $request->only(
                        "question",
                        "answer"                      
                    )
                );
        return redirect()->route('admin.auth.question')->withFlashSuccess('Questions and answers saved successfully.');    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionAnswerRepository->getQuestionDetail($id);
        return view("backend.auth.question_answer.show")->with('question',$question);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionAnswerRepository->getQuestionDetail($id);
        return view('backend.auth.question_answer.edit')->with('question',$question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*$validatedData = $request->validate([
                    'question' => 'required|string|max:255',
                    'answer' => 'required|string',
                    'answer_id' => 'required|integer', // Validate the answer ID as integer
                ]);*/
        $validatedData = $request->validate([
               'question' => [
                   'required',
                   'string',
                   //'max:255',
                   Rule::unique('questions')->ignore($id),
                   new \App\Rules\NotNumericOrSpecialChars,
               ],
               'answer' => 'required|string',
               'answer_id' => 'required|integer',
           ], [
              'question.unique' => 'This question is already exist.',
              'question.required' => 'The question field is required.',
              'answer.required' => 'The answer field is required.',
          ]);
        $this->questionAnswerRepository->update(
                    $request->only(
                        "question",
                        "answer",
                        'answer_id'                     
                    ),$id
                );       
        return redirect()->route('admin.auth.question')->withFlashSuccess('Question and answer updated successfully.');        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->questionAnswerRepository->deleteQA($id);
        return redirect()->route('admin.auth.question')->withFlashSuccess('Question and answer deleted successfully.');     
    }
}
