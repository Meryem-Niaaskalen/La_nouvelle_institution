<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',
            'teachers.manage',
            'programs.manage',
            'activities.manage',
            'gallery.manage',
            'testimonials.manage',
            'documents.manage',
            'homepage.manage',
            'settings.manage',
            'messages.manage',
            'users.manage',
            'roles.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $superAdmin = Role::findOrCreate('super_admin');
        $admin = Role::findOrCreate('admin');
        $editor = Role::findOrCreate('editor');
        $viewer = Role::findOrCreate('viewer');

        $superAdmin->syncPermissions($permissions);

        $admin->syncPermissions([
            'dashboard.view',
            'teachers.manage',
            'programs.manage',
            'activities.manage',
            'gallery.manage',
            'testimonials.manage',
            'documents.manage',
            'homepage.manage',
            'settings.manage',
            'messages.manage',
            'users.manage',
        ]);

        $editor->syncPermissions([
            'dashboard.view',
            'teachers.manage',
            'activities.manage',
            'gallery.manage',
            'homepage.manage',
            'documents.manage',
            'testimonials.manage',
        ]);

        $viewer->syncPermissions([
            'dashboard.view',
            'messages.manage',
        ]);

        $user = User::query()->updateOrCreate(
            ['email' => 'admin@lanouvelleinstitution.ma'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $user->syncRoles(['super_admin']);
    }
}
