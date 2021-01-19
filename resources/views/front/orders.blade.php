@extends('layouts.app')
@section('content')
    @if($orders)
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Orders</h1>
        </div>
        <!-- /.card-header -->
        @foreach($orders as $order)
        <div class="card-body">
            <div class="card">
                <div class="card-header" style="background-color: dodgerblue">
                    <h1 class="card-title" style="font-family: Arial">ITEMS({{$order->totalQty}})</h1>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-active">
                        <tr>
                            <th>PRODUCT</th>
                            <th>QUANTITY</th>
                            <th>UNIT PRICE</th>
                            <th>SUBTOTAL</th>
                        </tr>
                        </thead>
                        <tbody>
                       @foreach($order->items as $item)
                           <tr>
                               <td>
                                   <img src="{{asset('img/T-shirts/'.$item['photo'])}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                                   {{$item['name']}}
                               </td>
                               <td>{{$item['Qty']}}</td>
                               <td>
                                   ${{$item['price']}}
                               </td>
                               <td>
                                 ${{$item['qtyPrice']}}
                               </td>
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-6" style="margin-top: 50px">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Total Paid:</th>
                                        <td>$ {{$order->totalPrice}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            <!-- /.card-body -->
            </div>
        <!-- /.card -->
        </div>
    @endforeach

    <!-- /.card-body -->
    </div>
    @else
    <div class="form-control">Sorry No orders</div>
    @endif
    @endsection
