<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('product','allProducts','chat');
    }


    public function index()
    {
        return view('home');
    }
    public function admin()
    {
        return view('layouts.master');
    }
    public function post()
    {
        return view('front.post');
    }

    public function allProducts(Request $request)
    {
        //$categories=Category::all();
        if(request()->category){
            $products=Product::with('category')->whereHas('category',function ($query)use ($request){
                $query->where('name','=',Request()->category);
            })->get();
        }
        else{
            $products=Product::with('category')->whereHas('category',function ($query){
                $query->where('status',1);
            })->latest()->paginate(20);
        }
        $categories=Category::where('status',1)->whereHas('product')->get();
        //dd($categories);
        return view('front.product',compact('products','categories'));
    }

    public function product($id)
    {
        $product=Product::findorfail($id);
        return view('front.item',compact('product'));
    }
    public function user_photo(){
        $user_photo=Auth()->user()->photo;
        return response()->json($user_photo);
    }

}
