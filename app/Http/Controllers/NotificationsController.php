<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Auth;

class NotificationsController extends Controller
{
    public function get()
    {
        if (Auth::user()->check()) {
            $notifications = Auth::user()->get()->notifications;
        }
        else if(Auth::customer()->check()) {
            $notifications = Auth::customer()->get()->notifications;
        }

        return response()->json($notifications);
    }

    public static function send($user_id, $user_type, $message)
    {
        $notif = new Notification;
        $notif->user_id = $user_id;
        $notif->user_type = $user_type;
        $notif->notif = $message;

        if ($notif->save()) {
            return true;
        }

        return false;
    }
}
