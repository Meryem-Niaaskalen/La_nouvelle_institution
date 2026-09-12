<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;

class GalleryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Activité para', 'slug' => 'activite-para', 'description' => 'Activités parascolaires', 'order' => 1],
            ['name' => 'Compétitions', 'slug' => 'competitions', 'description' => 'Compétitions et concours scolaires', 'order' => 2],
            ['name' => 'Sorties scolaire', 'slug' => 'sorties-scolaire', 'description' => 'Sorties et visites scolaires', 'order' => 3],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Activités et événements sportifs', 'order' => 4],
            ['name' => 'Tournoi de foot', 'slug' => 'tournoi-de-foot', 'description' => 'Tournoi de football', 'order' => 5],
        ];

        foreach ($categories as $category) {
            GalleryCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
