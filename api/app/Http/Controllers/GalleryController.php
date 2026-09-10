<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryCategoryResource;
use App\Http\Resources\GalleryImageResource;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function categories(): JsonResponse
    {
        $categories = GalleryCategory::where('is_visible', true)
            ->with(['images' => function ($query) {
                $query->where('is_visible', true)->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        return response()->json([
            'data' => GalleryCategoryResource::collection($categories),
        ]);
    }

    public function category(GalleryCategory $category): JsonResponse
    {
        if (!$category->is_visible) {
            return response()->json(['message' => 'Non trouvé'], 404);
        }

        $category->load(['images' => function ($query) {
            $query->where('is_visible', true)->orderBy('order');
        }]);

        return response()->json([
            'data' => new GalleryCategoryResource($category),
        ]);
    }

    public function images(GalleryCategory $category): JsonResponse
    {
        if (!$category->is_visible) {
            return response()->json(['message' => 'Non trouvé'], 404);
        }

        $images = GalleryImage::where('category_id', $category->id)
            ->where('is_visible', true)
            ->orderBy('order')
            ->paginate(20);

        return response()->json([
            'data' => GalleryImageResource::collection($images->items()),
            'pagination' => [
                'total' => $images->total(),
                'per_page' => $images->perPage(),
                'current_page' => $images->currentPage(),
                'last_page' => $images->lastPage(),
            ],
        ]);
    }

    private function authorizeGalleryManagement(): void
    {
        if (!auth()->user()->can('gallery.manage') && !auth()->user()->can('manage_gallery')) {
            throw new AuthorizationException();
        }
    }

    public function adminCategories(): JsonResponse
    {
        $this->authorizeGalleryManagement();

        $categories = GalleryCategory::with('images')
            ->orderBy('order')
            ->get();

        return response()->json([
            'data' => GalleryCategoryResource::collection($categories),
        ]);
    }

    public function adminImages(GalleryCategory $category): JsonResponse
    {
        $this->authorizeGalleryManagement();

        $images = GalleryImage::where('category_id', $category->id)
            ->orderBy('order')
            ->get();

        return response()->json([
            'data' => GalleryImageResource::collection($images),
        ]);
    }

    public function storeCategory(Request $request): JsonResponse
    {
        $this->authorizeGalleryManagement();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_visible' => ['boolean'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['name']);
        $category = GalleryCategory::create($validated);

        return response()->json([
            'message' => 'Catégorie créée',
            'data' => new GalleryCategoryResource($category),
        ], 201);
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        if ($slug === '') {
            $slug = Str::random(8);
        }

        $original = $slug;
        $count = 1;

        while (GalleryCategory::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '<>', $ignoreId))
            ->exists()) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }

    public function updateCategory(GalleryCategory $category, Request $request): JsonResponse
    {
        $this->authorizeGalleryManagement();

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'string', 'unique:gallery_categories,slug,' . $category->id],
            'description' => ['nullable', 'string'],
            'is_visible' => ['boolean'],
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Catégorie mise à jour',
            'data' => new GalleryCategoryResource($category),
        ]);
    }

    public function destroyCategory(GalleryCategory $category): JsonResponse
    {
        $this->authorizeGalleryManagement();

        $category->delete();

        return response()->json(['message' => 'Catégorie supprimée']);
    }

    public function storeImage(Request $request): JsonResponse
    {
        $this->authorizeGalleryManagement();

        $validated = $request->validate([
            'category_id' => ['required', 'exists:gallery_categories,id'],
            'image' => ['required_without:image_file', 'nullable', 'url'],
            'image_file' => ['required_without:image', 'nullable', 'file', 'image', 'max:5120'],
            'thumbnail' => ['nullable', 'url'],
            'thumbnail_file' => ['nullable', 'file', 'image', 'max:5120'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_visible' => ['boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_path'] = $request->file('image_file')->store('gallery/images', 'public');
        } else {
            $validated['image_path'] = $validated['image'];
        }

        if ($request->hasFile('thumbnail_file')) {
            $validated['thumbnail'] = $request->file('thumbnail_file')->store('gallery/thumbnails', 'public');
        }

        $image = GalleryImage::create(array_filter($validated, fn ($value) => $value !== null && $value !== ''));

        return response()->json([
            'message' => 'Image ajoutée',
            'data' => new GalleryImageResource($image),
        ], 201);
    }

    public function updateImage(GalleryImage $image, Request $request): JsonResponse
    {
        $this->authorizeGalleryManagement();

        $validated = $request->validate([
            'category_id' => ['sometimes', 'exists:gallery_categories,id'],
            'image' => ['sometimes', 'url'],
            'image_file' => ['sometimes', 'file', 'image', 'max:5120'],
            'thumbnail' => ['nullable', 'url'],
            'thumbnail_file' => ['nullable', 'file', 'image', 'max:5120'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_visible' => ['boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_path'] = $request->file('image_file')->store('gallery/images', 'public');
        } elseif (array_key_exists('image', $validated)) {
            $validated['image_path'] = $validated['image'];
        }

        if ($request->hasFile('thumbnail_file')) {
            $validated['thumbnail'] = $request->file('thumbnail_file')->store('gallery/thumbnails', 'public');
        }

        $image->update(array_filter($validated, fn ($value) => $value !== null && $value !== ''));

        return response()->json([
            'message' => 'Image mise à jour',
            'data' => new GalleryImageResource($image),
        ]);
    }

    public function destroyImage(GalleryImage $image): JsonResponse
    {
        $this->authorizeGalleryManagement();

        $image->delete();

        return response()->json(['message' => 'Image supprimée']);
    }
}
