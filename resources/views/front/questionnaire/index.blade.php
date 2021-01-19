@extends('layouts.app')
@section('content')
   <div class="container">
       <div class="card">
           <div class="card-header">

       <div class="row justify-content-center">
           <div class="col-10">
               <label>Your Questionnaires</label>
           </div>
           <div class="col-2">
               <a class="btn btn-success" href="{{route('questionnaire.create')}}"><i class="fas fa-plus"></i>

                   Create a Survey</a>
           </div>
       </div>
           </div>
           <div class="card-body">

       @if($questionnaires->count()>0)
           <div class="row">
               <div class="col-4">
                   <label  style="font-weight: bold">
                       Questionnaire title
                   </label>
               </div>
               <div class="col-6">
                   <label  style="font-weight: bold">
                       Shared URL:
                   </label>
               </div>
               <div class="col-2">

               </div>
           </div>
       @foreach($questionnaires as $question)
              <div class="row">
                  <div class="col-sm-4">
                      <a class="form-control" href="{{route('questionnaire.show',$question->id)}}">
                          {{$question->title}}
                      </a>
                  </div>
                  <div class="col-6">

                          <input class="form-control" value="{{url('survey/'.$question->id.'-'.Str::slug($question->title))}}" style="color: dodgerblue">
                  </div>
                  <div class="col-sm-2">
                      <form action="{{route('questionnaire.destroy',$question->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" type="submit"><i class="fas fa-backspace"></i>
                          </button>

                      </form>

                  </div>
              </div>
                   <br>
           @endforeach
           </div>

       @else
       <div>
           You dont have any questionnaires yet,<a href="{{route('questionnaire.create')}}"> Click here to create one!</a>
       </div>
           @endif
       </div>
   </div>
@endsection
