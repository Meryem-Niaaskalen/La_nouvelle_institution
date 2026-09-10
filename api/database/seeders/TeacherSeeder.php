<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = ['Mathématiques', 'Sciences', 'Français', 'Anglais', 'Histoire-Géographie', 'Informatique'];
        $names = [
            ['Fatima', 'El Amrani'],
            ['Mohamed', 'Bennani'],
            ['Leila', 'Abdelaziz'],
            ['Ahmed', 'Rachid'],
            ['Noor', 'Hassan'],
            ['Youssef', 'Talbi'],
        ];

        foreach ($specializations as $index => $spec) {
            $firstName = $names[$index][0];
            $lastName = $names[$index][1];
            $email = strtolower($firstName . '.' . $lastName . '@nouvelle.school');

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => "$firstName $lastName",
                    'password' => bcrypt('teacher123'),
                    'status' => 'active',
                ]
            );
            $user->assignRole('teacher');

            Teacher::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'specialization' => $spec,
                    'diploma' => 'Licence en ' . $spec,
                    'experience_years' => rand(3, 20),
                    'bio' => "Enseignant passionné de $spec avec une expérience dans l'éducation moderne.",
                    'phone' => sprintf('+212 6 %02d %02d %02d %02d', rand(20, 99), rand(0, 99), rand(0, 99), rand(0, 99)),
                    'status' => 'active',
                    'hire_date' => now()->subYears(rand(1, 15)),
                ]
            );
        }
    }
}
