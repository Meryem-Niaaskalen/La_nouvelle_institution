<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@nouvelle.school'],
            [
                'name' => 'Admin Utilisateur',
                'password' => bcrypt('password123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->syncRoles(['admin']);

        $demoUser = User::firstOrCreate(
            ['email' => 'nouvel.admin@nouvelle.school'],
            [
                'name' => 'Nouvel Admin',
                'password' => bcrypt('password123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $demoUser->syncRoles(['user']);
    }
}