<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Questionnaire;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index($id){
        $questionnaire=Questionnaire::findorfail($id);
        $questions=$questionnaire->questions;
return response()->json($questions);
    }
    public function store(Request $request ,$id){
        Request()->validate([
           'questionTitle'=>'required',
            'answers'=>'required|array|max:5|min:2'
        ]);
        $questionnaire=Questionnaire::findorfail($id);
      $question =$questionnaire->questions()->create([
            'question'=>$request->questionTitle,
        ]);
      $answers=$request->answers;
      foreach($answers as $answer){
          $question->answers()->create([
              'answer'=>$answer,
        ]);
      }

    }
    public function edit($id){
        $question=Question::with('answers')->findorfail($id);
        return response()->json($question);

    }
    public function destroy($id)
    {
        $question=Question::findorfail($id);
        $question->delete();
    }
}
