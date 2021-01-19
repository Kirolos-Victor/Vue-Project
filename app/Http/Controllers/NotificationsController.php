<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index(){
       $userNotify= Auth::user()->notifications;
       if($userNotify)
       {
           return response()->json($userNotify);
       }
    }
    public function readNotify(){
       $unReadUserNotifications=Auth::user()->unReadNotifications;
        $unReadUserNotifications->markAsRead();
    }
    public function unReadNotify()
    {
        return Auth::user()->unReadNotifications;
    }
}
