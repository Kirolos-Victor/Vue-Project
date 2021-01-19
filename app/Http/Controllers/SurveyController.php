<?php

namespace App\Http\Controllers;

use App\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function show($id,$slug){
        $questionnaire=Questionnaire::findorfail($id)->load('questions.answers');
        //dd($questionnaire->questions);
        return view('front.questionnaire.survey',compact('questionnaire'));
    }
    public function store(Request $request,$id){
        //dd($request->all());
        $questionnaire=Questionnaire::findorfail($id);
        $messages=[
            'required'=>'Please select an answer',
            'name.required'=>'Please enter your name',
            'email.required'=>'Please enter your email'
        ];
        $data=Request()->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'responses'=>'required|array|min:1',
            'responses.*.answer_id'=>'required|exists:answers,id',
            'responses.*.question_id'=>'required|exists:questions,id'

        ],$messages);
        //dd($data['name']);
        $survey=$questionnaire->surveys()->create([
            'name'=>$data['name'],
            'email'=>$data['email']
        ]);
        $survey->responses()->createMany($data['responses']);
        return'Thank you!';
    }
    public function answer($id){
        $questionnaire=Questionnaire::findorfail($id);
        if($questionnaire->user_id == Auth()->user()->id){
            $questionnaire->load('questions.answers.responses');
            //dd($questionnaire);

            return view('front.questionnaire.answers',compact('questionnaire'));
        }
        else{
            return redirect()->back();
        }
    }

}
