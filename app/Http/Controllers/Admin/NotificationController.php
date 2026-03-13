<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth('admin')->user();

        $notifications = $user->notifications()->latest()->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function unreadCount()
    {
        return response()->json([
            'count' => auth('admin')->user()->unreadNotifications()->count()
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = auth('admin')->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $redirect = $request->input('redirect');
        if ($redirect) {
            return redirect($redirect);
        }

        return back();
    }

    public function markAllRead()
    {
        auth('admin')->user()->unreadNotifications->markAsRead();

        return back();
    }
}