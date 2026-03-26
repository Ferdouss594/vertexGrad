<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuditLogService;

class NotificationController extends Controller
{
    // GET /notifications/unread-count
    public function getUnreadCount(Request $request)
    {
        if (! setting('notifications_enabled', '1')) {
            return response()->json(['count' => 0]);
        }

        $user = auth('web')->user();

        if (! $user) {
            return response()->json(['count' => 0]);
        }

        $count = $user->unreadNotifications()->count();

        if (setting('notification_audit_enabled', '1')) {
            AuditLogService::log(
                event: 'viewed',
                description: setting('notifications_count_audit_description', 'Fetched unread notifications count'),
                category: 'notification',
                subject: $user,
                properties: [
                    'user_id' => $user->id,
                    'user_name' => $user->name ?? $user->username,
                    'unread_count' => $count,
                ]
            );
        }

        return response()->json([
            'count' => $count,
        ]);
    }

    // GET /notifications/{id}/read
    public function markAsRead($id)
    {
        if (! setting('notifications_enabled', '1')) {
            return back()->with('error', setting('notifications_disabled_message', 'Notifications are currently disabled.'));
        }

        $user = auth('web')->user();

        if (! $user) {
            abort(403, setting('notifications_require_auth_message', 'Unauthorized access.'));
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

        if (setting('notification_audit_enabled', '1')) {
            AuditLogService::log(
                event: 'notification_read',
                description: setting('notification_read_audit_description', 'Marked notification as read'),
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
        }

        $projectId = data_get($notification->data, 'project_id');

        if ($projectId && setting('notifications_redirect_to_project', '1')) {
            return redirect()->route('projects.show', $projectId);
        }

        $defaultRedirectRoute = setting('notifications_default_redirect_route', '');

        if (! empty($defaultRedirectRoute) && \Route::has($defaultRedirectRoute)) {
            return redirect()->route($defaultRedirectRoute);
        }

        return back();
    }

    // GET /notifications/mark-all-read
    public function markAllRead()
    {
        if (! setting('notifications_enabled', '1')) {
            return back()->with('error', setting('notifications_disabled_message', 'Notifications are currently disabled.'));
        }

        $user = auth('web')->user();

        if (! $user) {
            abort(403, setting('notifications_require_auth_message', 'Unauthorized access.'));
        }

        $unreadNotifications = $user->unreadNotifications()->get();
        $count = $unreadNotifications->count();

        $notificationIds = $unreadNotifications->pluck('id')->values()->toArray();

        $unreadNotifications->markAsRead();

        if (setting('notification_audit_enabled', '1')) {
            AuditLogService::log(
                event: 'notifications_read_all',
                description: setting('notifications_read_all_audit_description', 'Marked all notifications as read'),
                category: 'notification',
                subject: $user,
                properties: [
                    'count' => $count,
                    'notification_ids' => $notificationIds,
                ]
            );
        }

        return back()->with(
            'success',
            setting('notifications_mark_all_read_success_message', 'All notifications marked as read.')
        );
    }
}