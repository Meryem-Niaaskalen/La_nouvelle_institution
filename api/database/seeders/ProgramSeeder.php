<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Baccalauréat Scientifique',
                'slug' => 'bac-scientifique',
                'level' => 'lycee',
                'description' => 'Formation complète en sciences pour les lycéens',
                'objectives' => 'Préparation aux études scientifiques supérieures',
                'requirements' => 'Diplôme du collège et aptitudes en sciences',
                'duration_years' => 2,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Baccalauréat Littéraire',
                'slug' => 'bac-litteraire',
                'level' => 'lycee',
                'description' => 'Programme d\'études littéraires et philosophiques',
                'objectives' => 'Développer les compétences en analyse et expression',
                'requirements' => 'Diplôme du collège et intérêt pour les lettres',
                'duration_years' => 2,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Collège Général',
                'slug' => 'college-general',
                'level' => 'college',
                'description' => 'Enseignement général du collège',
                'objectives' => 'Formation équilibrée en toutes disciplines',
                'requirements' => 'Certificat de l\'école élémentaire',
                'duration_years' => 4,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'École Élémentaire',
                'slug' => 'ecole-elementaire',
                'level' => 'elementaire',
                'description' => 'Enseignement élémentaire fondamental',
                'objectives' => 'Acquisition des compétences de base',
                'requirements' => 'Âge approprié, inscription',
                'duration_years' => 5,
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($programs as $program) {
            Program::firstOrCreate(['slug' => $program['slug']], $program);
        }
    }
}
