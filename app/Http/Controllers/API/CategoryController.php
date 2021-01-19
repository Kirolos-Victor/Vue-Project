<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories=Category::with('product')->get();
        return response()->json($categories);
    }
    //select category
    public function categories(){
        $categories=Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:categories'
        ]);
        $category=Category::create($request->all());
        return response()->json($category);
    }


    //category status
    public function show($id)
    {
        $category=Category::findorfail($id);
        if($category->status == 0){
            $category->status = 1;
        }
        else{
            $category->status = 0;
        }
        $category->save();
       // dd($category->status);
    }


    public function update(Request $request, $id)
    {
        $category=Category::findorfail($id);
        $category->update(Request()->validate([
            'name'=>'required|unique:categories,name,'.$category->id
        ])
        );
        return response()->json($category);
    }


    public function destroy($id)
    {
        $category=Category::findorfail($id);
        $category->delete();
        return response()->json($category);
    }
}
