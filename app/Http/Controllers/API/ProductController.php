<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::with('category')->latest()->get();

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:products',
            'price'=>'required|numeric',
            'category_id'=>'required',
        ]);
        if($request->photo)
        {
            $name=time().'.'.explode('/',explode(':', substr($request->photo,0,strpos($request->photo,';')))[1])[1];
            $img=Image::make($request->photo);
            $img->save(public_path('img/T-shirts/').$name);
            $request->merge(['photo'=>$name]);
        }
        //dd($request);
       $product=Product::create($request->all());
       // we must type it as function category()-> not category->
       $product->category()->attach($request->category_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'required|unique:products,name,'.$product->id,
            'price'=>'required',
        ]);
        if($request->photo){
            $currentProductPhoto=$product->photo;
            if($request->photo != $currentProductPhoto){
                //we this this code line to name the extend of the image .jpg / pg/ w.e
                $name=time().'.'.explode('/',explode(':', substr($request->photo,0,strpos($request->photo,';')))[1])[1];
                $img=Image::make($request->photo);
                $img->save(public_path('img/T-shirts/').$name);
                $request->merge(['photo'=>$name]);
                $productPhoto= public_path('img/T-shirts/').$currentProductPhoto;
                if(file_exists($productPhoto)){
                    @unlink($productPhoto);
                }
            }
        }
        $product->update($request->all());
        $product->category()->sync($request->category_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $productPhoto= public_path('img/T-shirts/').$product->photo;
        @unlink($productPhoto);
        $product->delete();
        $product->category()->detach();

    }
}
