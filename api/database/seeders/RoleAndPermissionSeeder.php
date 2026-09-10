<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        $permissions = [
            // Users
            'manage_users', 'view_users', 'create_users', 'edit_users', 'delete_users',
            // Teachers
            'manage_teachers', 'view_teachers', 'create_teachers', 'edit_teachers', 'delete_teachers',
            // Gallery
            'manage_gallery', 'view_gallery', 'create_gallery', 'edit_gallery', 'delete_gallery',
            // Activities
            'manage_activities', 'view_activities', 'create_activities', 'edit_activities', 'delete_activities',
            // Programs
            'manage_programs', 'view_programs', 'create_programs', 'edit_programs', 'delete_programs',
            // Testimonials
            'manage_testimonials', 'view_testimonials', 'create_testimonials', 'edit_testimonials', 'delete_testimonials',
            // Documents
            'manage_documents', 'view_documents', 'create_documents', 'edit_documents', 'delete_documents',
            // Settings
            'manage_settings', 'view_settings', 'edit_settings',
            // Contact Messages
            'manage_contact', 'view_contact', 'respond_contact',
            // Blog
            'manage_blog', 'view_blog', 'create_blog', 'edit_blog', 'delete_blog',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $teacher = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'api']);
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'api']);

        // Admin has all permissions
        $admin->syncPermissions(Permission::all());

        // Teacher permissions
        $teacherPermissions = [
            'view_teachers', 'view_gallery', 'view_activities',
            'view_programs', 'view_testimonials', 'view_blog'
        ];
        $teacher->syncPermissions($teacherPermissions);

        // User permissions
        $userPermissions = ['view_gallery', 'view_activities', 'view_programs', 'view_blog'];
        $user->syncPermissions($userPermissions);
    }
}
