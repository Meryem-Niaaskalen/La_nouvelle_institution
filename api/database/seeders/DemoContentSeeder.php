<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\Program;
use App\Models\Teacher;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'full_name' => 'Amina Benali',
                'title' => 'Professeure de mathématiques',
                'subject' => 'Mathématiques',
                'bio' => 'Passionnée par la pédagogie active et la réussite de chaque élève.',
                'sort_order' => 1,
            ],
            [
                'full_name' => 'Youssef El Amrani',
                'title' => 'Professeur de sciences',
                'subject' => 'Sciences physiques',
                'bio' => 'Encourage l\'expérimentation et la curiosité scientifique.',
                'sort_order' => 2,
            ],
            [
                'full_name' => 'Sara Kadiri',
                'title' => 'Professeure de français',
                'subject' => 'Français',
                'bio' => 'Développe l\'expression écrite et orale avec bienveillance.',
                'sort_order' => 3,
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::query()->updateOrCreate(
                ['full_name' => $teacher['full_name']],
                [...$teacher, 'is_published' => true]
            );
        }

        $programs = [
            [
                'slug' => 'college',
                'title' => 'Collège',
                'summary' => 'Un parcours solide pour construire les bases académiques.',
                'description' => 'Programme collège centré sur l\'excellence, le suivi personnalisé et l\'ouverture culturelle.',
                'icon' => 'book',
                'sort_order' => 1,
                'features' => ['Suivi individualisé', 'Soutien scolaire', 'Activités extrascolaires'],
            ],
            [
                'slug' => 'lycee',
                'title' => 'Lycée',
                'summary' => 'Préparation exigeante au baccalauréat et aux études supérieures.',
                'description' => 'Accompagnement vers le bac et orientation post-bac avec une équipe engagée.',
                'icon' => 'graduation',
                'sort_order' => 2,
                'features' => ['Orientation', 'Préparation examens', 'Projets scientifiques'],
            ],
            [
                'slug' => 'langues',
                'title' => 'Langues & ouverture',
                'summary' => 'Français, arabe et langues étrangères pour une culture ouverte.',
                'description' => 'Renforcement linguistique et ateliers de communication.',
                'icon' => 'globe',
                'sort_order' => 3,
                'features' => ['Ateliers oraux', 'Clubs de lecture', 'Échanges culturels'],
            ],
        ];

        foreach ($programs as $programData) {
            $features = $programData['features'];
            unset($programData['features']);

            $program = Program::query()->updateOrCreate(
                ['slug' => $programData['slug']],
                [...$programData, 'is_published' => true]
            );

            $program->features()->delete();
            foreach ($features as $index => $label) {
                $program->features()->create([
                    'label' => $label,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        $activityCategories = [
            ['slug' => 'evenements', 'name' => 'Événements', 'sort_order' => 1],
            ['slug' => 'sport', 'name' => 'Sport', 'sort_order' => 2],
            ['slug' => 'science', 'name' => 'Science', 'sort_order' => 3],
            ['slug' => 'culture', 'name' => 'Culture', 'sort_order' => 4],
        ];

        foreach ($activityCategories as $category) {
            ActivityCategory::query()->updateOrCreate(['slug' => $category['slug']], $category);
        }

        $activities = [
            [
                'category' => 'evenements',
                'slug' => 'remise-des-diplomes',
                'title' => 'Remise des diplômes',
                'excerpt' => 'Une cérémonie solennelle pour célébrer la réussite de nos élèves.',
                'body' => 'Familles, enseignants et élèves se sont réunis pour honorer le parcours des diplômés.',
                'event_date' => now()->subMonths(2)->toDateString(),
                'is_featured' => true,
            ],
            [
                'category' => 'sport',
                'slug' => 'tournoi-sportif-interclasses',
                'title' => 'Tournoi sportif interclasses',
                'excerpt' => 'Esprit d\'équipe et fair-play au rendez-vous.',
                'body' => 'Plusieurs disciplines ont animé la journée sportive de l\'établissement.',
                'event_date' => now()->subMonths(1)->toDateString(),
                'is_featured' => true,
            ],
            [
                'category' => 'science',
                'slug' => 'exposition-scientifique',
                'title' => 'Exposition scientifique',
                'excerpt' => 'Les élèves présentent leurs projets scientifiques innovants.',
                'body' => 'Une journée dédiée à l\'expérimentation, à la curiosité et à la vulgarisation.',
                'event_date' => now()->subWeeks(3)->toDateString(),
                'is_featured' => true,
            ],
            [
                'category' => 'culture',
                'slug' => 'journee-des-meres',
                'title' => 'Journée des mères',
                'excerpt' => 'Un moment chaleureux de reconnaissance et de partage.',
                'body' => 'Spectacles, messages et attentions pour célébrer les mères.',
                'event_date' => now()->subMonths(3)->toDateString(),
                'is_featured' => false,
            ],
            [
                'category' => 'evenements',
                'slug' => 'celebration-aid',
                'title' => 'Célébration de l\'Aïd',
                'excerpt' => 'Une fête scolaire dans le respect et la convivialité.',
                'body' => 'Activités culturelles et moments de partage autour des valeurs de l\'Aïd.',
                'event_date' => now()->subMonths(4)->toDateString(),
                'is_featured' => false,
            ],
            [
                'category' => 'evenements',
                'slug' => 'journee-des-enseignants',
                'title' => 'Journée des enseignants',
                'excerpt' => 'Hommage à l\'engagement de notre équipe pédagogique.',
                'body' => 'Les élèves ont remercié leurs professeurs à travers des messages et des présentations.',
                'event_date' => now()->subMonths(5)->toDateString(),
                'is_featured' => false,
            ],
        ];

        foreach ($activities as $activityData) {
            $categorySlug = $activityData['category'];
            unset($activityData['category']);
            $categoryId = ActivityCategory::query()->where('slug', $categorySlug)->value('id');

            Activity::query()->updateOrCreate(
                ['slug' => $activityData['slug']],
                [
                    ...$activityData,
                    'category_id' => $categoryId,
                    'is_published' => true,
                ]
            );
        }

        $galleryCategories = [
            ['slug' => 'activite-para', 'name' => 'Activité para', 'sort_order' => 1],
            ['slug' => 'competitions', 'name' => 'Compétitions', 'sort_order' => 2],
            ['slug' => 'sorties-scolaire', 'name' => 'Sorties scolaire', 'sort_order' => 3],
            ['slug' => 'sports', 'name' => 'Sports', 'sort_order' => 4],
            ['slug' => 'tournoi-de-foot', 'name' => 'Tournoi de foot', 'sort_order' => 5],
        ];

        foreach ($galleryCategories as $category) {
            GalleryCategory::query()->updateOrCreate(['slug' => $category['slug']], $category);
        }

        $galleryImages = [
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'Al mawlid 1.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'Al mawlid 2.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'AL mawlid 3.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'amazighiya.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'amazighiya 2.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'automne 1.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'automne 2.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'Automne 3.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'Eid Al Adha.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'la marche verte.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'marche verte 2.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'marche verte 4.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'printemps1.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'printemps 2.jpg'],
            ['category' => 'activite-para', 'directory' => 'activité para', 'filename' => 'printemps 3.jpg'],

            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'English 2.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'English comp.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'Il9a2 chi3ri.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'Il9a2 chi3ri 2.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'Il9a2 chi3ri 3.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'Tajwid.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'Tajwid 2.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'Tajwid 3.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'Tajwid 4.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'Tajwid 5.jpg'],
            ['category' => 'competitions', 'directory' => 'competitions', 'filename' => 'Tajwid 6.jpg'],

            ['category' => 'sorties-scolaire', 'directory' => 'sorties scolaire', 'filename' => '1.jpg'],
            ['category' => 'sorties-scolaire', 'directory' => 'sorties scolaire', 'filename' => '2.jpg'],
            ['category' => 'sorties-scolaire', 'directory' => 'sorties scolaire', 'filename' => '3.jpg'],
            ['category' => 'sorties-scolaire', 'directory' => 'sorties scolaire', 'filename' => '4.jpg'],
            ['category' => 'sorties-scolaire', 'directory' => 'sorties scolaire', 'filename' => '5.jpg'],
            ['category' => 'sorties-scolaire', 'directory' => 'sorties scolaire', 'filename' => '6.jpg'],
            ['category' => 'sorties-scolaire', 'directory' => 'sorties scolaire', 'filename' => '7.jpg'],
            ['category' => 'sorties-scolaire', 'directory' => 'sorties scolaire', 'filename' => '8.jpg'],
            ['category' => 'sorties-scolaire', 'directory' => 'sorties scolaire', 'filename' => '9.jpg'],

            ['category' => 'sports', 'directory' => 'sports', 'filename' => 'sports 1.jpg'],
            ['category' => 'sports', 'directory' => 'sports', 'filename' => 'sport 2.jpg'],
            ['category' => 'sports', 'directory' => 'sports', 'filename' => 'sports 3.jpg'],
            ['category' => 'sports', 'directory' => 'sports', 'filename' => 'Sports 4.jpg'],
            ['category' => 'sports', 'directory' => 'sports', 'filename' => 'sports 5.jpg'],
            ['category' => 'sports', 'directory' => 'sports', 'filename' => 'Sports 6.jpg'],
            ['category' => 'sports', 'directory' => 'sports', 'filename' => 'Sports 7.jpg'],
            ['category' => 'sports', 'directory' => 'sports', 'filename' => 'sports 8.jpg'],
            ['category' => 'sports', 'directory' => 'sports', 'filename' => 'sports 9.jpg'],

            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '1.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '2.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '3.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '4.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '5.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '6.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '7.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '8.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '9.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '10.jpg'],
            ['category' => 'tournoi-de-foot', 'directory' => 'tournoi de foot', 'filename' => '11.jpg'],
        ];

        foreach ($galleryImages as $index => $image) {
            $categoryId = GalleryCategory::query()->where('slug', $image['category'])->value('id');
            $imagePath = '/images/' . $image['directory'] . '/' . $image['filename'];
            $title = pathinfo($image['filename'], PATHINFO_FILENAME);

            GalleryImage::query()->updateOrCreate(
                ['image' => $imagePath],
                [
                    'category_id' => $categoryId,
                    'title' => $title,
                    'image_path' => $imagePath,
                    'order' => $index + 1,
                    'is_visible' => true,
                ]
            );
        }

        $testimonials = [
            [
                'author_name' => 'Fatima Zahra',
                'author_role' => 'Parent d\'élève',
                'content' => 'Une école sérieuse, à l\'écoute, où mon enfant progresse dans un climat bienveillant.',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'author_name' => 'Mehdi',
                'author_role' => 'Élève de terminale',
                'content' => 'Les professeurs nous poussent vers l\'excellence tout en restant disponibles.',
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'author_name' => 'Imane',
                'author_role' => 'Ancienne élève',
                'content' => 'Les valeurs et la rigueur acquises ici m\'ont beaucoup aidée dans mes études supérieures.',
                'rating' => 5,
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::query()->updateOrCreate(
                ['author_name' => $testimonial['author_name'], 'author_role' => $testimonial['author_role']],
                [...$testimonial, 'is_published' => true]
            );
        }
    }
}
