@extends('layouts.app')
@section('content')
<messenger-chat username="{{auth()->user()->name}}"></messenger-chat>
    @endsection
