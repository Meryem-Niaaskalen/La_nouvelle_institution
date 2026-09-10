<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use App\Models\SiteSetting;
use App\Models\Statistic;
use App\Models\TimelineEvent;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group_name' => 'school', 'key' => 'school_name', 'value' => 'La nouvelle institution'],
            ['group_name' => 'school', 'key' => 'founded_year', 'value' => '1997'],
            ['group_name' => 'contact', 'key' => 'phone', 'value' => '05228-75634'],
            ['group_name' => 'contact', 'key' => 'email', 'value' => 'gsni2527@gmail.com'],
            ['group_name' => 'contact', 'key' => 'address', 'value' => '25 Rue Adawha El Fath 3, Casablanca, Morocco'],
            ['group_name' => 'contact', 'key' => 'maps_query', 'value' => '25 Rue Adawha El Fath 3, Casablanca, Morocco'],
            ['group_name' => 'social', 'key' => 'facebook_url', 'value' => 'https://web.facebook.com/profile.php?id=100056328531139&sk=photos'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        HomepageSection::query()->updateOrCreate(
            ['key' => 'hero'],
            [
                'is_enabled' => true,
                'content' => [
                    'eyebrow' => 'Depuis 1997',
                    'title' => 'La nouvelle institution',
                    'subtitle' => 'Une école moderne, exigeante et accueillante au cœur de Casablanca.',
                    'cta_label' => 'Découvrir l\'école',
                    'cta_url' => '/a-propos',
                ],
            ]
        );

        HomepageSection::query()->updateOrCreate(
            ['key' => 'about_teaser'],
            [
                'is_enabled' => true,
                'content' => [
                    'title' => 'Une institution de confiance',
                    'text' => 'Depuis plus de vingt-cinq ans, La nouvelle institution accompagne les élèves vers l\'excellence académique et l\'épanouissement personnel.',
                ],
            ]
        );

        HomepageSection::query()->updateOrCreate(
            ['key' => 'school_life'],
            [
                'is_enabled' => true,
                'content' => [
                    'title' => 'Vie scolaire',
                    'items' => [
                        ['label' => 'Sports', 'description' => 'Compétitions et activités sportives'],
                        ['label' => 'Culture', 'description' => 'Arts, théâtre et expressions créatives'],
                        ['label' => 'Science', 'description' => 'Projets scientifiques et expositions'],
                        ['label' => 'Clubs', 'description' => 'Clubs élèves et initiatives citoyennes'],
                        ['label' => 'Sorties', 'description' => 'Voyages et sorties pédagogiques'],
                    ],
                ],
            ]
        );

        $timeline = [
            [
                'year_label' => '1997',
                'title' => 'Création de l\'établissement',
                'description' => 'Ouverture de La nouvelle institution à Casablanca.',
                'icon' => 'school',
                'sort_order' => 1,
            ],
            [
                'year_label' => '+25 ans',
                'title' => 'Des générations d\'élèves formées',
                'description' => 'Une expérience pédagogique solide et une communauté fidèle.',
                'icon' => 'graduates',
                'sort_order' => 2,
            ],
            [
                'year_label' => 'Aujourd\'hui',
                'title' => 'Enseignement moderne',
                'description' => 'Outils numériques, équipe engagée et accompagnement personnalisé.',
                'icon' => 'modern',
                'sort_order' => 3,
            ],
        ];

        TimelineEvent::query()->delete();
        foreach ($timeline as $event) {
            TimelineEvent::query()->create($event);
        }

        $stats = [
            ['key' => 'students', 'label' => 'Élèves', 'value' => 850, 'icon' => 'users', 'sort_order' => 1],
            ['key' => 'teachers', 'label' => 'Enseignants', 'value' => 62, 'icon' => 'chalkboard', 'sort_order' => 2],
            ['key' => 'graduates', 'label' => 'Diplômés', 'value' => 4200, 'icon' => 'graduation', 'sort_order' => 3],
            ['key' => 'years', 'label' => 'Années d\'expérience', 'value' => 29, 'icon' => 'calendar', 'sort_order' => 4],
        ];

        foreach ($stats as $stat) {
            Statistic::query()->updateOrCreate(['key' => $stat['key']], $stat);
        }
    }
}
