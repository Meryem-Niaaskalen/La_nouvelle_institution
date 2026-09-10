<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;

class GalleryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Salles de classe', 'slug' => 'salles-de-classe', 'description' => 'Nos salles de classe modernes', 'order' => 1],
            ['name' => 'Événements', 'slug' => 'evenements', 'description' => 'Événements scolaires et célébrations', 'order' => 2],
            ['name' => 'Activités sportives', 'slug' => 'activites-sportives', 'description' => 'Sports et événements sportifs', 'order' => 3],
            ['name' => 'Projets étudiants', 'slug' => 'projets-etudiants', 'description' => 'Projets réalisés par les étudiants', 'order' => 4],
            ['name' => 'Vie scolaire', 'slug' => 'vie-scolaire', 'description' => 'Moments de la vie quotidienne à l\'école', 'order' => 5],
        ];

        foreach ($categories as $category) {
            GalleryCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
