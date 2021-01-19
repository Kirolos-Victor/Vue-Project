<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
}
    public function index()
    {
        return view('front.chat');
    }
    public function send(Request $request)
    {
        $user=Auth()->user();
       $this->chatSession($request);
        event(new ChatEvent($request->message,$user));
    }
    public function chatSession(Request $request)
    {
      session()->put('chat',$request->chat);
    }
    public function getOldMessage()
    {
        return session('chat');
    }
}
