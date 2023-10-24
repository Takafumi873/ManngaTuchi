<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\InformationNotification;
use illuminate\Support\facades\Notification;

class InformationController extends Controller
{
    public function store(Request $request)
    {
        //お知らせテーブルへ登録
        $information =  Information::create([
           'date' => $request->get('date'),
           'title' => $request->get('title'),
           'content' => $request->get('content'),
           ]);
           
        $user = User::find($request->get('user_id'));
        $user->notify(
            new InformationNotification($information)
            );
    }
    
    
}
?>