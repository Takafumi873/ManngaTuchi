<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        
        return redirect($noitfication->data['url']);
    }
    
    public function readAll(DatabaseNotification $notification)
    {
        aurh()->user()->unreadNotifications->markAsRead();
        
        return redirect(route('notifications.index'));
    }
       
    
}
?>