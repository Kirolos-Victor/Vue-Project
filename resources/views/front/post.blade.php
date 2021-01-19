@extends('layouts.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

    <div style="margin-right: 20%; position: relative;left: 10%">
      <post   :id="{{auth()->user()->id}}" name="{{auth()->user()->name}}"></post>
  </div>
    @endsection
