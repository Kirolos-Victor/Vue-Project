@extends('layouts.app')
@section('content')
    <div class="container w-50 ml-6" style="font-family: Arial;">
        <div class="card">
            <div class="card-header bg-white">
                <h3 class="ml-1">{{$questionnaire->title}}</h3>
                <h5 class="ml-2">{{$questionnaire->purpose}}</h5>
                <div class="row" style="margin-top: 30px">
                    <div class="col-6" >
                        <a href="{{url('survey/'.$questionnaire->id.'-'.Str::slug($questionnaire->title))}}" style="color: dodgerblue">Take a survey</a>&nbsp;|&nbsp;<a href="{{url('survey/'.$questionnaire->id.'/answers')}}" style="color: dodgerblue">View answers</a>
                    </div>
                </div>
            </div>
            <survey-question :questionnaire_id="{{$questionnaire->id}}"></survey-question>

        </div>
    </div>
    @endsection
