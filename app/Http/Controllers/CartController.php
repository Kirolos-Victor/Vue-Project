<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Notifications\InvoicePaid;
use App\Order;
use App\Product;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    public function totalQty(){
        if(session()->has('cart')){
           $totalQuantity=session()->get('cart')->totalQty;
        }
        else
        {
            $totalQuantity=0;
        }
        return response()->json($totalQuantity);
    }

    public function cart()
    {
        if(session()->has('cart')){
            $cart=new Cart(session()->get('cart'));
        }
        else
        {
            $cart= Null;
        }
        //dd($cart);
        return view('front.cart',compact('cart'));
    }

    public function addToCart(Product $product)
    {
        if(session()->has('cart')){
            $cart=new Cart(session()->get('cart'));
        }
        else
        {
            $cart= new Cart();
        }
        $cart->add($product);
        //dd($cart);
        session()->put('cart',$cart);
        //Alert::success('Success', 'Product was added successfully');
        return redirect()->back();
    }
    public function payment()
    {
        if(session()->has('cart')){
            $cart=new Cart(session()->get('cart'));
        }
        else
        {
            $cart= Null;
        }
        return view('front.payment',compact('cart'));
    }
    public function charge(Request $request)
    {
        $totalPrice=session()->get('cart')->totalPrice;
        //dd($request->stripeToken);
        \Stripe\Stripe::setApiKey('sk_test_xYx7RdmUqUnZf8PhO49oFCAn009KvLY9DQ');
        $charge=Stripe::Charges()->create([
            'currency'=>'usd',
            'source'=>$request->stripeToken,
            'amount'=>$totalPrice,
            'description'=>'My first payment from Laravel',
        ]);
        if($charge){
            $user=Auth::user();
           // $user->notify(new InvoicePaid($totalPrice));
            $user->order()->create([
                'cart'=>serialize(session()->get('cart'))
            ]);
            session()->forget('cart');
            //Alert::toast('Thanks for your purchase', 'success');
            return redirect(url('products'))->with('success','Thanks for purchasing from our store!');
        }
        else{
            return redirect()->back();
        }
    }
    public function updateQuantity($id, Request $request)
    {
        $request->validate([
           'qtyNumber'=>'required|min:1|max:100|numeric'
        ]);
        $cart=new Cart(session()->get('cart'));
        $cart->update($id,$request->qtyNumber);
        session()->put('cart',$cart);
        Alert::toast('Quantity updated', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $cart=new Cart(session()->get('cart'));
        $cart->remove($id);
        if($cart->totalQty <= 0)
        {
            session()->forget('cart');
        }
        else
        {
            session()->put('cart',$cart);
        }
        Alert::toast('Item removed', 'success');
        return redirect()->back();
    }

    public function myOrders()
    {
       $order=Auth::user()->order;

       //dd($order);
        $orders=$order->transform(function ($cart){
           return unserialize($cart->cart);
       });
       //dd($orders);
        return view('front.orders',compact('orders'));
    }





}
