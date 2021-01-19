<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials= $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('authToken')->accessToken;
            return response()->json(['successful login','token' => $token], 200);
        } else {
            return response()->json(['message'=>'Invalid login credentials'], 401);
        }
    }
    public function register(Request $request){
       $registerValidation=$request->validate( [
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'string', 'min:8', 'confirmed'],
           'city_id'=>'required',
           'governorate_id'=>'required',
       ]);
       if($registerValidation){
          $user= User::create([
               'name' => $request['name'],
               'email' => $request['email'],
               'password' => Hash::make($request['password']),
               'city_id'=>$request['city_id'],
               'governorate_id'=>$request['governorate_id'],
           ]);
           $token = $user->createToken('authToken')->accessToken;

           return response()->json(['token'=>$token]);
       }

    }
    public function logout(){
        auth()->user()->tokens()->each(function ($token ,$key){
            $token->revoke();

        });
        return response()->json('logged out successfully');
    }
}
