<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // Lycée
            ['name' => 'Mathématiques', 'code' => 'MATH-LYC', 'level' => 'lycee', 'credits' => 4],
            ['name' => 'Sciences Physiques', 'code' => 'SCI-LYC', 'level' => 'lycee', 'credits' => 4],
            ['name' => 'Sciences Naturelles', 'code' => 'SVT-LYC', 'level' => 'lycee', 'credits' => 3],
            ['name' => 'Français', 'code' => 'FR-LYC', 'level' => 'lycee', 'credits' => 3],
            ['name' => 'Anglais', 'code' => 'EN-LYC', 'level' => 'lycee', 'credits' => 3],
            ['name' => 'Histoire-Géographie', 'code' => 'HG-LYC', 'level' => 'lycee', 'credits' => 3],
            ['name' => 'Informatique', 'code' => 'INFO-LYC', 'level' => 'lycee', 'credits' => 2],
            ['name' => 'Éducation Physique', 'code' => 'EPS-LYC', 'level' => 'lycee', 'credits' => 2],
            // Collège
            ['name' => 'Mathématiques', 'code' => 'MATH-COL', 'level' => 'college', 'credits' => 3],
            ['name' => 'Sciences', 'code' => 'SCI-COL', 'level' => 'college', 'credits' => 3],
            ['name' => 'Français', 'code' => 'FR-COL', 'level' => 'college', 'credits' => 3],
            ['name' => 'Anglais', 'code' => 'EN-COL', 'level' => 'college', 'credits' => 2],
            // Élémentaire
            ['name' => 'Français', 'code' => 'FR-ELEM', 'level' => 'elementaire', 'credits' => 3],
            ['name' => 'Mathématiques', 'code' => 'MATH-ELEM', 'level' => 'elementaire', 'credits' => 3],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(['code' => $subject['code']], $subject);
        }
    }
}
