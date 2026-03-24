<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuditLogService;

class NotificationController extends Controller
{
    // GET /notifications/unread-count
    public function getUnreadCount(Request $request)
    {
        $user = auth('web')->user();

        if (! $user) {
            return response()->json(['count' => 0]);
        }

        $count = $user->unreadNotifications()->count();

        AuditLogService::log(
            event: 'viewed',
            description: 'Fetched unread notifications count',
            category: 'notification',
            subject: $user,
            properties: [
                'user_id' => $user->id,
                'user_name' => $user->name ?? $user->username,
                'unread_count' => $count,
            ]
        );

        return response()->json([
            'count' => $count,
        ]);
    }

    // GET /notifications/{id}/read
    public function markAsRead($id)
    {
        $user = auth('web')->user();

        if (! $user) {
            abort(403);
        }

        $notification = $user->notifications()->where('id', $id)->firstOrFail();

        $oldValues = [
            'notification_id' => $notification->id,
            'type' => $notification->type,
            'read_at' => $notification->read_at,
            'data' => $notification->data,
        ];

        $notification->markAsRead();
        $notification->refresh();

        AuditLogService::log(
            event: 'notification_read',
            description: 'Marked notification as read',
            category: 'notification',
            subject: $user,
            oldValues: $oldValues,
            newValues: [
                'notification_id' => $notification->id,
                'type' => $notification->type,
                'read_at' => $notification->read_at,
                'data' => $notification->data,
            ],
            properties: [
                'notification_id' => $notification->id,
                'notification_type' => $notification->type,
                'project_id' => data_get($notification->data, 'project_id'),
            ]
        );

        $projectId = data_get($notification->data, 'project_id');
        if ($projectId) {
            return redirect()->route('projects.show', $projectId);
        }

        return back();
    }

    // GET /notifications/mark-all-read
    public function markAllRead()
    {
        $user = auth('web')->user();

        if (! $user) {
            abort(403);
        }

        $unreadNotifications = $user->unreadNotifications()->get();
        $count = $unreadNotifications->count();

        $notificationIds = $unreadNotifications->pluck('id')->values()->toArray();

        $unreadNotifications->markAsRead();

        AuditLogService::log(
            event: 'notifications_read_all',
            description: 'Marked all notifications as read',
            category: 'notification',
            subject: $user,
            properties: [
                'count' => $count,
                'notification_ids' => $notificationIds,
            ]
        );

        return back()->with('success', 'All notifications marked as read.');
    }
}