<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // GET /notifications/unread-count
    public function getUnreadCount(Request $request)
    {
        $user = auth('web')->user();

        if (!$user) {
            return response()->json(['count' => 0]);
        }

        return response()->json([
            'count' => $user->unreadNotifications()->count()
        ]);
    }

    // GET /notifications/{id}/read
    public function markAsRead($id)
    {
        $user = auth('web')->user();

        if (!$user) {
            abort(403);
        }

        $n = $user->notifications()->where('id', $id)->firstOrFail();
        $n->markAsRead();

        // Optional: go to project if exists
        $projectId = data_get($n->data, 'project_id');
        if ($projectId) {
            return redirect()->route('projects.show', $projectId);
        }

        return back();
    }

    // GET /notifications/mark-all-read
    public function markAllRead()
    {
        $user = auth('web')->user();

        if (!$user) {
            abort(403);
        }

        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}