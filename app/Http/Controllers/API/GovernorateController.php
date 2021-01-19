<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $governorates=Governorate::paginate(10);
        return response()->json($governorates);
    }

    public function index2()
    {
        $governorates=Governorate::paginate(100);
        return response()->json($governorates);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:governorates'
        ]);
        $governorate=Governorate::create($request->all());
        return response()->json($governorate);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        if($name){
           $governorate=Governorate::where(function ($query)use($name){
               $query->where('name','LIKE',"%{$name}%");

            })->paginate(10);
        }
        return response()->json($governorate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Governorate $governorate)
    {

        $governorate->update(Request()->validate([
            'name'=>'required|unique:governorates,name,'.$governorate->id
        ])
        );
        return response()->json($governorate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Governorate $governorate)
    {
        $governorate->delete();
   
    }
}
