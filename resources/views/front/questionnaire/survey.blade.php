<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- all CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- Fonts
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
         i dont know what is this used for ..-->
</head>
<body>
    <div class="container w-50" style="margin-top: 10px;">
        @if($questionnaire->questions()->count()>0)
        <form action="{{url('survey/'.$questionnaire->id.'-'.Str::slug($questionnaire->title))}}" method="post">
            @csrf

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title mt-1">Your Information</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Your name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{old('name')}}">
                        </div>
                        @error('name')
                        <div class="text-danger" style="margin-bottom: 20px; font-weight: bold;">{{$message}}</div>
                        @enderror
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" value="{{old('email')}}">
                        </div>
                        @error('email')
                        <div class="text-danger" style="margin-bottom: 20px; font-weight: bold;">{{$message}}</div>
                        @enderror
                    </div>
                    <!-- /.card-body -->
            </div>
            <!--another way to loop $questionnaire=>questions as $key->$question -->
            @foreach($questionnaire->questions as $key=>$question)
        <div class="card">
            <div class="card-header">
                <h4 style="font-weight: bold">{{$loop->iteration}}-&nbsp;{{$question->question}}</h4>
            </div>
            <div class="card-body">
                @error('responses.'.$key.'.answer_id')
                <div class="text-danger" style="margin-bottom: 20px; font-weight: bold;">{{$message}}</div>
                @enderror
                <ul class="list-group" style="font-family: Arial;font-size: 16px">
                    @foreach($question->answers as $answer)
                       <label for="answer{{$answer->id}}">
                           <li class="list-group-item list-group-item-action">
                               <!--loop inside loop it duplicate id and to differenciate between them
                                add $key to element name
                                -->
                               <input type="radio" name="responses[{{$key}}][answer_id]" id="answer{{$answer->id}}"
                               value="{{$answer->id}}" {{(old('responses.'.$key.'.answer_id')==$answer->id)?'checked':''}}>&nbsp; {{$answer->answer}}
                               <input type="hidden"  name="responses[{{$key}}][question_id]" value="{{$question->id}}">
                           </li>
                       </label>
                        @endforeach
                </ul>
            </div>

        </div>
            @endforeach
            <button type="submit" class="btn btn-success text-center float-right " style="width: 20%;margin-bottom: 30px">Done</button>
        </form>
        @else
                <div class="form-control bg-white">Sorry, you didnt create any questions,
                    <a class="badge bg-blue"
                       style="cursor: pointer;"
                       onclick="history.back();">
                        <i class="ft-x"></i>click here to go back</a>
                </div>
            @endif
    </div>
</body>
</html>
