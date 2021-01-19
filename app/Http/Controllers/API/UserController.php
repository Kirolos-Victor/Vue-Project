<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __construct()
    {
        //can is used from of the Gate
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return User::paginate(10);


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
                'name'=>'required',
                'email'=>'required|unique:users',
                'password'=>'required'
                ]);
        $user=User::create($request->all());
        $user->password=Hash::make($request->password);
        $user->save();
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user=Auth('api')->user();

        return response()->json($user);
    }
    public function updateProfile(Request $request)
    {
        $user=Auth('api')->user();
        $this->validate($request,[
            'name'=>'required',
            'password'=>'sometimes|required',//sometimes means if you put the password its required if you didnt type the password then its not required
            'email'=>'required|unique:users,email,'.$user->id,
        ]);
        $currentphoto=$user->photo;
        if($request->photo != $currentphoto){
            //we this this code line to name the extend of the image .jpg / pg/ w.e
            $name=time().'.'.explode('/',explode(':', substr($request->photo,0,strpos($request->photo,';')))[1])[1];
           $img=Image::make($request->photo);
           $img->save(public_path('img/profile/').$name);
           $request->merge(['photo'=>$name]);
           $userPhoto= public_path('img/profile/').$currentphoto;
           if(file_exists($userPhoto)){
               @unlink($userPhoto);
           }
        }
        if(!empty($request->password))
        {
            $request->merge(['password'=>Hash::make($request->password)]);
        }
        $user->update($request->all());
        return response()->json($user);
    }
    public function search(Request $request){
        if ($q=$request->get('q')){
            $users=User::where(function ($query) use ($q){
               $query->where('name','LIKE',"%{$q}%")->orwhere('email','LIKE',"%{$q}%");
            })->paginate(10);
        }
        return response()->json($users);

    }

    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findorfail($id);

        $this->validate($request,[
           'name'=>'required',
           'password'=>'sometimes|required',
           'email'=>'required |unique:users,email,'.$user->id,
        ]);
        $user->update($request->all());
        $user->password=Hash::make($request->password);
        $user->save();
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $user=User::findorfail($id);
        $user->delete();
        return response()->json($user);
    }
}
