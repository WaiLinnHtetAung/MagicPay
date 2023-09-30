<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index() {
        $notis = auth()->user()->notifications;
        return view('frontend.notification', compact('notis'));
    }

    public function show($id) {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();

        return view('frontend.notification_detail', compact('notification'));
    }
}
