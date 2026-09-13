<?php

namespace Database\Seeders;

use App\Models\Actuality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ActualitySeeder extends Seeder
{
    public function run(): void
    {
        $actualities = [
            [
                'title' => 'Remise des diplômes',
                'category' => 'Événements',
                'description' => 'Une cérémonie solennelle pour célébrer la réussite de nos élèves. Familles, enseignants et élèves se sont réunis pour honorer le parcours des diplômés.',
                'image_path' => '/images/school-poster.jpg',
                'sort_order' => 1,
                'is_visible' => true,
                'is_pinned' => true,
            ],
            [
                'title' => 'Tournoi sportif interclasses',
                'category' => 'Activités',
                'description' => 'Esprit d\'équipe et fair-play au rendez-vous. Plusieurs disciplines ont animé la journée sportive de l\'établissement.',
                'image_path' => '/images/school-poster-2.jpg',
                'sort_order' => 2,
                'is_visible' => true,
                'is_pinned' => false,
            ],
            [
                'title' => 'Exposition scientifique',
                'category' => 'Activités',
                'description' => 'Les élèves présentent leurs projets scientifiques innovants. Une journée dédiée à l\'expérimentation, à la curiosité et à la vulgarisation.',
                'image_path' => '/images/school-front.jpg',
                'sort_order' => 3,
                'is_visible' => true,
                'is_pinned' => false,
            ],
            [
                'title' => 'Journée des mères',
                'category' => 'Vie scolaire',
                'description' => 'Un moment chaleureux de reconnaissance et de partage. Spectacles, messages et attentions pour célébrer les mères.',
                'image_path' => '/images/school-front-2.jpg',
                'sort_order' => 4,
                'is_visible' => true,
                'is_pinned' => false,
            ],
            [
                'title' => 'Célébration de l\'Aïd',
                'category' => 'Événements',
                'description' => 'Une fête scolaire dans le respect et la convivialité, avec des activités culturelles et des moments de partage.',
                'image_path' => '/images/school-front-3.jpg',
                'sort_order' => 5,
                'is_visible' => true,
                'is_pinned' => false,
            ],
            [
                'title' => 'Journée des enseignants',
                'category' => 'Événements',
                'description' => 'Hommage à l\'engagement de notre équipe pédagogique. Les élèves ont remercié leurs professeurs à travers des messages et des présentations.',
                'image_path' => '/images/school-flyer.jpg',
                'sort_order' => 6,
                'is_visible' => true,
                'is_pinned' => false,
            ],
        ];

        foreach ($actualities as $actuality) {
            $relativeImagePath = ltrim($actuality['image_path'], '/');
            if (!File::exists(public_path($relativeImagePath))) {
                continue;
            }

            Actuality::withTrashed()->updateOrCreate(
                ['title' => $actuality['title']],
                $actuality,
            );
        }
    }
}
