@extends('layouts.app')
@section('content')
    <div class="content">
        @if($questionnaire->questions()->count()>0)
            <div class="small-box bg-dark " style="padding-top: 10px;padding-left: 10px;">
                <h3 style="padding-left: 10px;">{{$questionnaire->title}}</h3>
                      <div class="inner d-flex justify-content-between">

                         <small> Number of users who took this survey :&nbsp;<span class="badge badge-info">{{$questionnaire->surveys->count()}}</span></small>
              </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
                @foreach($questionnaire->questions as $key=>$question)
                    <div class="card">
                        <div class="card-header">
                            <h4 style="font-weight: bold">{{$loop->iteration}}-&nbsp;{{$question->question}}</h4>
                        </div>
                        <div class="card-body">
                          <div class="row">
                              <div class="col-5">
                                  <ul class="list-group " style="font-family: Arial;font-size: 16px">
                                      @foreach($question->answers as $answer)
                                              <li class="list-group-item list-group-item-action d-flex justify-content-between" style="border: 1px solid black">
                                                 <div> {{$answer->answer}}</div>
                                                  @if($question->responses->count() > 0)
                                                  <div class="badge badge-danger text-center float-right" style="width: 50px; padding-top: 6px">
                                                      {{intval($answer->responses->count() * 100 / $question->responses->count())}}%</div>
                                                      @else
                                                      <div class="badge badge-danger text-center float-right" style="width: 50px; padding-top: 6px">
                                                        0%</div>
                                                      @endif
                                              </li>
                                      @endforeach
                                  </ul>
                              </div>
                              <div class="col-7">
                                <answer-chart :question="{{$question}}"></answer-chart>
                              </div>
                          </div>
                        </div>

                    </div>
                @endforeach
            <button onclick="window.print()">Print</button>

            <a class="btn btn-dark float-right"
                       style="cursor: pointer; margin-bottom: 50px;color: white"
                       onclick="history.back();">
                        <i class="fa fa-backward"></i> &nbsp;click here to go back</a>
        @else
            <div class="form-control bg-white">Sorry, you didnt create any questions,
                <a class="badge bg-blue"
                   style="cursor: pointer;"
                   onclick="history.back();">
                    <i class="ft-x"></i>click here to go back</a>
            </div>
        @endif
    </div>
@endsection
