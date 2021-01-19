<?php

namespace App\Http\Controllers;

use App\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionnaires=Auth::user()->questionnaires()->get();
        return view('front.questionnaire.index',compact('questionnaires'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.questionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=Request()->validate([
            'title'=>'required',
            'purpose'=>'required',
        ]);

          $questionnaire= Auth()->user()->questionnaires()->create($data);
          if($questionnaire){
              return redirect(route('questionnaire.show',$questionnaire->id));
          }
          else{
              return redirect()->back();

          }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questionnaire=Questionnaire::findorfail($id);

        if($questionnaire->user_id == Auth()->user()->id){
            return view('front.questionnaire.show',compact('questionnaire'));
        }
        else{
            return redirect()->back();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $questionnaire=Questionnaire::findorfail($id);
        $questionnaire->delete();
        return redirect()->back();
    }
}
