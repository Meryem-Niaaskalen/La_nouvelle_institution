<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Calendrier Scolaire', 'slug' => 'calendrier', 'description' => 'Calendrier officiel de l\'établissement', 'order' => 1],
            ['name' => 'Règlements', 'slug' => 'reglements', 'description' => 'Règlements intérieurs et directives', 'order' => 2],
            ['name' => 'Bulletins d\'information', 'slug' => 'bulletins', 'description' => 'Bulletins d\'information périodiques', 'order' => 3],
            ['name' => 'Formulaires', 'slug' => 'formulaires', 'description' => 'Formulaires d\'inscription et dossiers', 'order' => 4],
            ['name' => 'Ressources Éducatives', 'slug' => 'ressources', 'description' => 'Matériel d\'étude et ressources pédagogiques', 'order' => 5],
        ];

        foreach ($categories as $category) {
            DocumentCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
