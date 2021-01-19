@extends('layouts.app')
@section('content')
   <div class="container">
       <div class="card card-info">
           <div class="card-header">
               <h3 class="card-title">Questionnaire</h3>
           </div>
           <!-- /.card-header -->
           <!-- form start -->
           <form class="form-horizontal" action="{{route('questionnaire.store')}}" method="post">
               @csrf
               <div class="card-body">
                   <div class="form-group row">
                       <label  class="col-sm-2 col-form-label">Title</label>
                       <div class="col-sm-10">
                           <input type="text" class="form-control" placeholder="Enter title" name="title">
                           <small  class="form-text text-muted">Give your questionnaire a title that attracts attention.</small>
                       </div>
                       @error('title')
                       <span>
                    <div class="text-danger">
                   {{$message}}
               </div>
           </span>
                       @enderror
                   </div>
                   <div class="form-group row">
                       <label for="inputPassword3" class="col-sm-2 col-form-label">Purpose</label>
                       <div class="col-sm-10">
                           <input type="text" class="form-control"  placeholder="Enter purpose" name="purpose">
                       </div>
                       @error('purpose')
                       <span>
                    <div class="text-danger">
                   {{$message}}
               </div>
           </span>
                       @enderror
                   </div>
               </div>
               <!-- /.card-body -->
               <div class="card-footer">
                   <button type="submit" class="btn btn-info">Next</button>
                   <a href="{{route('questionnaire.index')}}" class="btn btn-default float-right">Cancel</a>
               </div>
               <!-- /.card-footer -->
           </form>
       </div>
   </div>
    @endsection
