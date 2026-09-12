<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@nouvelle.school'],
            [
                'name' => 'Admin Utilisateur',
                'password' => bcrypt('password123'),
                'is_active' => true,
            ]
        );

        $admin->assignRole('admin');

        // Create sample user
        $user = User::firstOrCreate(
            ['email' => 'nouvel.admin@nouvelle.school'],
            [
                'name' => 'Nouvel Admin',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );

        $user->assignRole('user');
    }
}