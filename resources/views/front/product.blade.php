@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="my-4">Shop Name</h1>
                <div class="list-group">
                        @foreach($categories as $category)
                    <a href="{{url('products?category='.$category->name)}}" class="list-group-item">{{$category->name}}</a>
                        @endforeach
                </div>
            </div>
            <!-- /.col-lg-3 -->
            <div class="col-lg-9">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{session()->get('success')}}
                    </div>
                @endif
                <div class="row">
                  @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <h4 class="card-title" style="margin-left: 20px;margin-top: 20px">
                                    <a href="{{url('products/'.$product->id)}}">{{$product->name}}</a>
                                </h4>
                                <div class="card-body">
                                    <a href="{{url('products/'.$product->id)}}">
                                        <img src="{{url('img/T-shirts/'.$product->photo)}}" style="width: 140px;margin-top: 20px;margin-left: 35px;">
                                    </a>

                                </div>
                                <div class="card-footer">
                                    <h5>${{$product->price}}</h5>
                                </div>
                            </div>
                        </div>
                      @endforeach
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->
    </div>
@endsection

