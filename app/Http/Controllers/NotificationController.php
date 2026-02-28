<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUnreadCount()
    {
        // This automatically detects if it's 'web' or 'admin'
        $user = Auth::user(); 
        
        return response()->json([
            'count' => $user ? $user->unreadNotifications->count() : 0
        ]);
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        // If a redirect URL was provided in the query string, go there. 
        // Otherwise, just go back.
        $redirectUrl = request('redirect');
        return $redirectUrl ? redirect($redirectUrl) : back();
    }
}