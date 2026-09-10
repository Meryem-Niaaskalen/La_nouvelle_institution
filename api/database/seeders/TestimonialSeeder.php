<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'author_name' => 'Mme Fatima Bennani',
                'author_role' => 'Parent d\'élève',
                'content' => 'La nouvelle institution offre un excellent environnement d\'apprentissage pour mon enfant. Les enseignants sont très engagés et le programme est complet.',
                'testimonial_type' => 'parent',
                'rating' => 5,
                'is_published' => true,
                'featured' => true,
                'order' => 1,
            ],
            [
                'author_name' => 'Youssef Al-Mansouri',
                'author_role' => 'Élève, Bac Scientifique',
                'content' => 'J\'ai vraiment apprécié mon expérience à La nouvelle institution. Les professeurs sont passionnés et les installations sont modernes.',
                'testimonial_type' => 'student',
                'rating' => 5,
                'is_published' => true,
                'featured' => true,
                'order' => 2,
            ],
            [
                'author_name' => 'Ahmed El Houari',
                'author_role' => 'Ancien élève, Classe de 2015',
                'content' => 'La nouvelle institution m\'a préparé pour la réussite à l\'université. L\'éducation que j\'ai reçue ici m\'a vraiment aidé.',
                'testimonial_type' => 'former_student',
                'rating' => 5,
                'is_published' => true,
                'featured' => false,
                'order' => 3,
            ],
            [
                'author_name' => 'Mme Leila Abdelkader',
                'author_role' => 'Parent d\'élève',
                'content' => 'Excellente école avec une vraie politique pédagogique moderne. Mes deux enfants y sont très épanouis.',
                'testimonial_type' => 'parent',
                'rating' => 5,
                'is_published' => true,
                'featured' => false,
                'order' => 4,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::firstOrCreate(
                ['author_name' => $testimonial['author_name']],
                $testimonial
            );
        }
    }
}
