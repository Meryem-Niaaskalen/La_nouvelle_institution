<?php

namespace Database\Seeders;

use App\Models\ActivityCategory;
use Illuminate\Database\Seeder;

class ActivityCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sports', 'slug' => 'sports', 'type' => 'sports', 'description' => 'Événements et activités sportives'],
            ['name' => 'Culture', 'slug' => 'culture', 'type' => 'culture', 'description' => 'Activités culturelles et artistiques'],
            ['name' => 'Science', 'slug' => 'science', 'type' => 'science', 'description' => 'Expositions et projets scientifiques'],
            ['name' => 'Clubs', 'slug' => 'clubs', 'type' => 'clubs', 'description' => 'Activités des clubs scolaires'],
            ['name' => 'Sorties', 'slug' => 'sorties', 'type' => 'trips', 'description' => 'Sorties et voyages pédagogiques'],
            ['name' => 'Événements', 'slug' => 'evenements', 'type' => 'general', 'description' => 'Événements spéciaux et célébrations'],
        ];

        foreach ($categories as $category) {
            ActivityCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
