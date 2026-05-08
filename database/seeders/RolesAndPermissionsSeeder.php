<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $roles = [
                ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Full system access'],
                ['name' => 'Manager', 'slug' => 'manager', 'description' => 'Main full-control manager of the platform'],
                ['name' => 'Supervisor', 'slug' => 'supervisor', 'description' => 'Supervisor with customizable permissions'],
                ['name' => 'Student', 'slug' => 'student', 'description' => 'Creates and manages own projects'],
                ['name' => 'Investor', 'slug' => 'investor', 'description' => 'Browses and invests in projects'],
            ];

            $permissions = [
                ['name' => 'Access Admin Panel', 'slug' => 'access_admin_panel', 'group' => 'admin', 'description' => 'Can access admin dashboard'],
                ['name' => 'Manage Users', 'slug' => 'manage_users', 'group' => 'users', 'description' => 'Can manage users'],
                ['name' => 'Manage Roles & Permissions', 'slug' => 'manage_roles_permissions', 'group' => 'users', 'description' => 'Can manage roles and permissions'],
                ['name' => 'Manage Settings', 'slug' => 'manage_settings', 'group' => 'settings', 'description' => 'Can manage system settings'],
                ['name' => 'View Projects', 'slug' => 'view_projects', 'group' => 'projects', 'description' => 'Can view projects'],
                ['name' => 'Create Projects', 'slug' => 'create_projects', 'group' => 'projects', 'description' => 'Can create projects'],
                ['name' => 'Edit Projects', 'slug' => 'edit_projects', 'group' => 'projects', 'description' => 'Can edit projects'],
                ['name' => 'Delete Projects', 'slug' => 'delete_projects', 'group' => 'projects', 'description' => 'Can delete projects'],
                ['name' => 'Approve Projects', 'slug' => 'approve_projects', 'group' => 'projects', 'description' => 'Can approve projects'],
                ['name' => 'Review Projects', 'slug' => 'review_projects', 'group' => 'projects', 'description' => 'Can review projects'],
                ['name' => 'View Reports', 'slug' => 'view_reports', 'group' => 'reports', 'description' => 'Can view reports'],
                ['name' => 'Export Reports', 'slug' => 'export_reports', 'group' => 'reports', 'description' => 'Can export reports'],
                ['name' => 'Manage Report Templates', 'slug' => 'manage_report_templates', 'group' => 'reports', 'description' => 'Can manage report templates'],
                ['name' => 'Manage Scheduled Reports', 'slug' => 'manage_scheduled_reports', 'group' => 'reports', 'description' => 'Can manage scheduled reports'],
                ['name' => 'View Report History', 'slug' => 'view_report_history', 'group' => 'reports', 'description' => 'Can view report history'],
                ['name' => 'Manage Announcements', 'slug' => 'manage_announcements', 'group' => 'announcements', 'description' => 'Can manage announcements'],
                ['name' => 'View Notifications', 'slug' => 'view_notifications', 'group' => 'notifications', 'description' => 'Can view notifications'],
                ['name' => 'Manage Notifications', 'slug' => 'manage_notifications', 'group' => 'notifications', 'description' => 'Can manage notifications'],
                ['name' => 'Send Messages', 'slug' => 'send_messages', 'group' => 'messages', 'description' => 'Can send messages'],
                ['name' => 'Reply Messages', 'slug' => 'reply_messages', 'group' => 'messages', 'description' => 'Can reply to messages'],
                ['name' => 'Manage Contact Messages', 'slug' => 'manage_contact_messages', 'group' => 'messages', 'description' => 'Can manage contact messages'],
                ['name' => 'View Investors', 'slug' => 'view_investors', 'group' => 'investors', 'description' => 'Can view investors'],
                ['name' => 'Edit Investors', 'slug' => 'edit_investors', 'group' => 'investors', 'description' => 'Can edit investor data'],
                ['name' => 'Manage Investor Notes', 'slug' => 'manage_investor_notes', 'group' => 'investors', 'description' => 'Can manage investor notes'],
                ['name' => 'Evaluate Projects', 'slug' => 'evaluate_projects', 'group' => 'projects', 'description' => 'Can evaluate projects'],
                ['name' => 'View Meetings', 'slug' => 'view_meetings', 'group' => 'meetings', 'description' => 'Can view meetings'],
                ['name' => 'Manage Meetings', 'slug' => 'manage_meetings', 'group' => 'meetings', 'description' => 'Can create and manage meetings'],
                ['name' => 'View Requests', 'slug' => 'view_requests', 'group' => 'requests', 'description' => 'Can view requests'],
                ['name' => 'Manage Requests', 'slug' => 'manage_requests', 'group' => 'requests', 'description' => 'Can create and manage requests'],
                ['name' => 'Manage System Verification', 'slug' => 'manage_system_verification', 'group' => 'verification', 'description' => 'Can update system verification'],
                ['name' => 'View Audit Logs', 'slug' => 'view_audit_logs', 'group' => 'audit', 'description' => 'Can view audit logs'],
                ['name' => 'View Contact Messages', 'slug' => 'view_contact_messages', 'group' => 'messages', 'description' => 'Allows the user to view contact messages submitted from the frontend.'],
                ['name' => 'Reply Contact Messages', 'slug' => 'reply_contact_messages', 'group' => 'messages', 'description' => 'Allows the user to send replies to contact messages.'],
                ['name' => 'Update Contact Message Status', 'slug' => 'update_contact_message_status', 'group' => 'messages', 'description' => 'Allows the user to update contact message statuses.'],
            ];

            foreach ($roles as $roleData) {
                Role::query()->updateOrCreate(
                    ['slug' => $roleData['slug']],
                    $roleData
                );
            }

            foreach ($permissions as $permissionData) {
                Permission::query()->updateOrCreate(
                    ['slug' => $permissionData['slug']],
                    $permissionData
                );
            }

            $rolePermissions = [
                'admin' => [
                    'access_admin_panel',
                    'approve_projects',
                    'create_projects',
                    'delete_projects',
                    'edit_investors',
                    'edit_projects',
                    'export_reports',
                    'manage_announcements',
                    'manage_contact_messages',
                    'manage_investor_notes',
                    'manage_meetings',
                    'manage_notifications',
                    'manage_report_templates',
                    'manage_roles_permissions',
                    'manage_requests',
                    'manage_scheduled_reports',
                    'manage_settings',
                    'manage_system_verification',
                    'manage_users',
                    'reply_messages',
                    'review_projects',
                    'send_messages',
                    'view_audit_logs',
                    'view_investors',
                    'view_meetings',
                    'view_notifications',
                    'view_projects',
                    'view_requests',
                    'view_report_history',
                    'view_reports',
                    'evaluate_projects',
                ],
                'manager' => [
                    'access_admin_panel',
                    'approve_projects',
                    'create_projects',
                    'delete_projects',
                    'edit_investors',
                    'edit_projects',
                    'export_reports',
                    'manage_announcements',
                    'manage_contact_messages',
                    'manage_investor_notes',
                    'manage_meetings',
                    'manage_notifications',
                    'manage_report_templates',
                    'manage_roles_permissions',
                    'manage_requests',
                    'manage_scheduled_reports',
                    'manage_settings',
                    'manage_system_verification',
                    'manage_users',
                    'reply_messages',
                    'review_projects',
                    'send_messages',
                    'view_audit_logs',
                    'view_investors',
                    'view_meetings',
                    'view_notifications',
                    'view_projects',
                    'view_requests',
                    'view_report_history',
                    'view_reports',
                    'evaluate_projects',
                ],
                'supervisor' => [
                    'access_admin_panel',
                    'send_messages',
                    'reply_messages',
                    'review_projects',
                    'view_notifications',
                    'view_projects',
                ],
                'student' => [
                    'create_projects',
                    'edit_projects',
                    'send_messages',
                    'reply_messages',
                    'view_notifications',
                    'view_projects',
                ],
                'investor' => [
                    'send_messages',
                    'reply_messages',
                    'view_investors',
                    'view_notifications',
                    'view_projects',
                ],
            ];

            foreach ($rolePermissions as $roleSlug => $permissionSlugs) {
                $role = Role::query()->where('slug', $roleSlug)->firstOrFail();
                $permissionIds = Permission::query()
                    ->whereIn('slug', $permissionSlugs)
                    ->pluck('id')
                    ->all();

                $role->permissions()->sync($permissionIds);
            }

            DB::table('role_user')->delete();

            $roleIdsByName = Role::query()->pluck('id', 'name');

            $rows = User::query()
                ->whereIn('role', $roleIdsByName->keys())
                ->get()
                ->map(function (User $user) use ($roleIdsByName) {
                    return [
                        'role_id' => $roleIdsByName[$user->role],
                        'user_id' => $user->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })
                ->all();

            if (!empty($rows)) {
                DB::table('role_user')->insert($rows);
            }
        });
    }
}
