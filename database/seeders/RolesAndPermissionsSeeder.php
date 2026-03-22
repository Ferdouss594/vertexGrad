<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1) Create Roles
        |--------------------------------------------------------------------------
        */
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Full system access',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Main full-control manager of the platform',
            ],
            [
                'name' => 'Supervisor',
                'slug' => 'supervisor',
                'description' => 'Supervisor with customizable permissions',
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
                'description' => 'Creates and manages own projects',
            ],
            [
                'name' => 'Investor',
                'slug' => 'investor',
                'description' => 'Browses and invests in projects',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 2) Create Permissions
        |--------------------------------------------------------------------------
        */
        $permissions = [
            // Admin / Access
            ['name' => 'Access Admin Panel', 'slug' => 'access_admin_panel', 'group' => 'admin', 'description' => 'Can access admin dashboard'],
            ['name' => 'Manage Users', 'slug' => 'manage_users', 'group' => 'users', 'description' => 'Can manage users'],
            ['name' => 'Manage Roles & Permissions', 'slug' => 'manage_roles_permissions', 'group' => 'users', 'description' => 'Can manage roles and permissions'],
            ['name' => 'Manage Settings', 'slug' => 'manage_settings', 'group' => 'settings', 'description' => 'Can manage system settings'],

            // Projects
            ['name' => 'View Projects', 'slug' => 'view_projects', 'group' => 'projects', 'description' => 'Can view projects'],
            ['name' => 'Create Projects', 'slug' => 'create_projects', 'group' => 'projects', 'description' => 'Can create projects'],
            ['name' => 'Edit Projects', 'slug' => 'edit_projects', 'group' => 'projects', 'description' => 'Can edit projects'],
            ['name' => 'Delete Projects', 'slug' => 'delete_projects', 'group' => 'projects', 'description' => 'Can delete projects'],
            ['name' => 'Approve Projects', 'slug' => 'approve_projects', 'group' => 'projects', 'description' => 'Can approve projects'],
            ['name' => 'Review Projects', 'slug' => 'review_projects', 'group' => 'projects', 'description' => 'Can review projects'],
            ['name' => 'Evaluate Projects', 'slug' => 'evaluate_projects', 'group' => 'projects', 'description' => 'Can evaluate projects'],

            // Meetings
            ['name' => 'View Meetings', 'slug' => 'view_meetings', 'group' => 'meetings', 'description' => 'Can view meetings'],
            ['name' => 'Manage Meetings', 'slug' => 'manage_meetings', 'group' => 'meetings', 'description' => 'Can create and manage meetings'],

            // Requests
            ['name' => 'View Requests', 'slug' => 'view_requests', 'group' => 'requests', 'description' => 'Can view requests'],
            ['name' => 'Manage Requests', 'slug' => 'manage_requests', 'group' => 'requests', 'description' => 'Can create and manage requests'],

            // Verification
            ['name' => 'Manage System Verification', 'slug' => 'manage_system_verification', 'group' => 'verification', 'description' => 'Can update system verification'],

            // Reports
            ['name' => 'View Reports', 'slug' => 'view_reports', 'group' => 'reports', 'description' => 'Can view reports'],
            ['name' => 'Export Reports', 'slug' => 'export_reports', 'group' => 'reports', 'description' => 'Can export reports'],
            ['name' => 'Manage Report Templates', 'slug' => 'manage_report_templates', 'group' => 'reports', 'description' => 'Can manage report templates'],
            ['name' => 'Manage Scheduled Reports', 'slug' => 'manage_scheduled_reports', 'group' => 'reports', 'description' => 'Can manage scheduled reports'],
            ['name' => 'View Report History', 'slug' => 'view_report_history', 'group' => 'reports', 'description' => 'Can view report history'],

            // Announcements
            ['name' => 'Manage Announcements', 'slug' => 'manage_announcements', 'group' => 'announcements', 'description' => 'Can manage announcements'],

            // Notifications
            ['name' => 'View Notifications', 'slug' => 'view_notifications', 'group' => 'notifications', 'description' => 'Can view notifications'],
            ['name' => 'Manage Notifications', 'slug' => 'manage_notifications', 'group' => 'notifications', 'description' => 'Can manage notifications'],

            // Messages / Contact
            ['name' => 'Send Messages', 'slug' => 'send_messages', 'group' => 'messages', 'description' => 'Can send messages'],
            ['name' => 'Reply Messages', 'slug' => 'reply_messages', 'group' => 'messages', 'description' => 'Can reply to messages'],
            ['name' => 'Manage Contact Messages', 'slug' => 'manage_contact_messages', 'group' => 'messages', 'description' => 'Can manage contact messages'],

            // Investors
            ['name' => 'View Investors', 'slug' => 'view_investors', 'group' => 'investors', 'description' => 'Can view investors'],
            ['name' => 'Edit Investors', 'slug' => 'edit_investors', 'group' => 'investors', 'description' => 'Can edit investor data'],
            ['name' => 'Manage Investor Notes', 'slug' => 'manage_investor_notes', 'group' => 'investors', 'description' => 'Can manage investor notes'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::updateOrCreate(
                ['slug' => $permissionData['slug']],
                $permissionData
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 3) Attach Permissions To Roles
        |--------------------------------------------------------------------------
        */
        $admin = Role::where('slug', 'admin')->first();
        $manager = Role::where('slug', 'manager')->first();
        $supervisor = Role::where('slug', 'supervisor')->first();
        $student = Role::where('slug', 'student')->first();
        $investor = Role::where('slug', 'investor')->first();

        $allPermissions = Permission::pluck('id')->toArray();

        // Admin = full access
        $admin?->permissions()->sync($allPermissions);

        // Manager = full access as requested
        $manager?->permissions()->sync($allPermissions);

        // Supervisor = base permissions only
        // Extra permissions like meetings / requests / evaluation / verification
        // will be granted manually from the permissions management page.
        $supervisorPermissions = Permission::whereIn('slug', [
            'access_admin_panel',
            'view_projects',
            'review_projects',
            'view_notifications',
            'send_messages',
            'reply_messages',
        ])->pluck('id')->toArray();

        $supervisor?->permissions()->sync($supervisorPermissions);

        // Student
        $studentPermissions = Permission::whereIn('slug', [
            'create_projects',
            'edit_projects',
            'view_projects',
            'view_notifications',
            'send_messages',
            'reply_messages',
        ])->pluck('id')->toArray();

        $student?->permissions()->sync($studentPermissions);

        // Investor
        $investorPermissions = Permission::whereIn('slug', [
            'view_projects',
            'view_notifications',
            'send_messages',
            'reply_messages',
            'view_investors',
        ])->pluck('id')->toArray();

        $investor?->permissions()->sync($investorPermissions);

        /*
        |--------------------------------------------------------------------------
        | 4) Attach Current Users To Matching Roles
        |--------------------------------------------------------------------------
        */
        $users = User::all();

        foreach ($users as $user) {
            $matchedRole = Role::where('name', $user->role)->first();

            if ($matchedRole) {
                $user->roles()->syncWithoutDetaching([$matchedRole->id]);
            }
        }
    }
}