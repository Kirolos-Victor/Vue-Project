<?php

namespace App\Http\Controllers\API;

use App\City;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index()
    {
        $city=City::paginate(5);
        return response()->json($city);
    }
    public function index2(Request $request)
    {
        $city=City::where(function ($query)use ($request){
            if($request->governorate_id){
                $query->where('governorate_id','=',$request->governorate_id);
            }
        })->paginate(100);
        return response()->json($city);
    }



    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required|unique:cities',
            'governorate_id'=>'required'
        ]);
        $id=City::insertGetId([
        'name'=>$request->name,
        'governorate_id'=>$request->governorate_id,
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now()]);
        //dd($id);
        $oneCity=City::findorfail($id);


        return response()->json($oneCity);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function update(Request $request, City $city)
    {
        $this->validate($request,[
           'name'=>'required|unique:cities,name,'.$city->id,
           'governorate_id'=>'required'
        ]);
        $city->update($request->all());

        return response()->json($city);
    }



    public function destroy(City $city)
    {
        $city->delete();
        return response()->json($city);
    }
}
