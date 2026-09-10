<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            TeacherSeeder::class,
            SubjectSeeder::class,
            ProgramSeeder::class,
            ActivityCategorySeeder::class,
            GalleryCategorySeeder::class,
            TestimonialSeeder::class,
            DocumentCategorySeeder::class,
            SettingSeeder::class,
        ]);
    }
}
