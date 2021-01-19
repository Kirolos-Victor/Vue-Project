@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    @if($cart)
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <span class="fas fa-shopping-cart">
                                        Cart ({{$cart->totalQty}})
                                    </span>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- Table row -->
                        <div class="row">

                            <div class="col-12 table-responsive">
                                @error ('qtyNumber')
                                    <div class="alert alert-danger">
                                        <ul>
                                           <li>Sorry invalid number of quantities</li>
                                        </ul>
                                    </div>
                                @enderror

                                <table class="table border ">
                                    <thead class="table-active">
                                    <tr>
                                        <th>#</th>
                                        <th>ITEM</th>
                                        <th>QUANTITY</th>
                                        <th>UNIT PRICE</th>
                                        <th>SUBTOTAL</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cart->items as $product)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$product['name']}}</td>
                                        <td>
                                            <form action="{{url('cart/'.$product['id'])}}" method="post">
                                                @csrf
                                                @method('put')
                                                <input type="number" name="qtyNumber" value="{{$product['Qty']}}" class="form-control-sm">
                                                <button type="submit" class="btn btn-primary">Change</button>
                                            </form>
                                        </td>
                                        <td>$ {{$product['price']}}</td>
                                        <td>$ {{$product['qtyPrice']}}</td>
                                        <td><form action="{{url('cart/'.$product['id'])}}" method="post">
                                                @csrf
                                               @method('delete')
                                                <button type="submit" class="btn btn-danger">Remove</button>
                                            </form></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-6">
                            </div>
                            <div class="col-6" style="margin-top: 50px">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Total:</th>
                                            <td>$ {{$cart->totalPrice}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a id="print" onclick="myPrint()" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                <a href="{{asset(url('payment'))}}" class="btn btn-success float-right"> CONTINUE TO CHECKOUT
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                        No products
                @endif
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @endsection
@section('scripts')
    <script>
        function myPrint() {
            window.print();

        }
    </script>
    @endsection
