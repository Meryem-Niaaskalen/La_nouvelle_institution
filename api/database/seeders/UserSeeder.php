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
                'status' => 'active',
            ]
        );
        $admin->assignRole('admin');

        // Create sample users
        $users = [
            [
                'name' => 'Nouvel Admin',
                'email' => 'nouvel.admin@nouvelle.school',
                'password' => bcrypt('password'),
                'phone' => '+212 5 22 87 56 34',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(['email' => $userData['email']], $userData);
            $user->assignRole('user');
        }
    }
}
