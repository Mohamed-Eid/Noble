<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth('client')->user()->notifications();
        return view('web.notifications.index',compact('notifications'));
    }
}
