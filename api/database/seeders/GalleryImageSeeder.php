<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryImageSeeder extends Seeder
{
    public function run(): void
    {
        $imagesRoot = public_path('images');
        if (!File::isDirectory($imagesRoot)) {
            return;
        }

        $categoryIds = GalleryCategory::query()
            ->whereIn('slug', [
                'activite-para',
                'competitions',
                'sorties-scolaire',
                'sports',
                'tournoi-de-foot',
            ])
            ->pluck('id', 'slug');

        foreach (File::directories($imagesRoot) as $directory) {
            $folderName = basename($directory);
            $categorySlug = Str::slug($folderName);
            $categoryId = $categoryIds->get($categorySlug);

            if (!$categoryId) {
                continue;
            }

            $files = File::files($directory);
            usort($files, fn ($left, $right) => strcasecmp($left->getFilename(), $right->getFilename()));

            foreach ($files as $index => $file) {
                if (!in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'avif'], true)) {
                    continue;
                }

                $relativePath = 'images/' . $folderName . '/' . $file->getFilename();
                $imagePath = '/' . str_replace('\\', '/', $relativePath);

                GalleryImage::query()->updateOrCreate(
                    ['image' => $imagePath],
                    [
                        'category_id' => $categoryId,
                        'title' => pathinfo($file->getFilename(), PATHINFO_FILENAME),
                        'order' => $index + 1,
                        'is_visible' => true,
                    ],
                );
            }
        }
    }
}
