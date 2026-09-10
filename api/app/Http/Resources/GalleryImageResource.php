<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GalleryImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = $this->image ?: $this->image_path;
        if ($imageUrl) {
            if (!str_starts_with($imageUrl, 'http') && !str_starts_with($imageUrl, '/')) {
                $imageUrl = Storage::disk('public')->url($imageUrl);
            }

            // Ensure spaces and special characters in path segments are URL-encoded
            if (str_starts_with($imageUrl, '/')) {
                $trimmed = ltrim($imageUrl, '/');
                $parts = explode('/', $trimmed);
                $encoded = implode('/', array_map('rawurlencode', $parts));
                $imageUrl = '/' . $encoded;

                // Make absolute using APP_URL so frontend dev server loads images from backend
                $appUrl = rtrim(config('app.url') ?: env('APP_URL', 'http://127.0.0.1:8000'), '/');
                $imageUrl = $appUrl . $imageUrl;
            }
        }

        $thumbnailUrl = $this->thumbnail;
        if ($thumbnailUrl) {
            if (!str_starts_with($thumbnailUrl, 'http') && !str_starts_with($thumbnailUrl, '/')) {
                $thumbnailUrl = Storage::disk('public')->url($thumbnailUrl);
            }

            if (str_starts_with($thumbnailUrl, '/')) {
                $trimmedT = ltrim($thumbnailUrl, '/');
                $partsT = explode('/', $trimmedT);
                $encodedT = implode('/', array_map('rawurlencode', $partsT));
                $thumbnailUrl = '/' . $encodedT;

                $appUrlT = rtrim(config('app.url') ?: env('APP_URL', 'http://127.0.0.1:8000'), '/');
                $thumbnailUrl = $appUrlT . $thumbnailUrl;
            }
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $imageUrl,
            'thumbnail_url' => $thumbnailUrl,
            'sort_order' => $this->order,
            'is_visible' => $this->is_visible,
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category?->id,
                'slug' => $this->category?->slug,
                'name' => $this->category?->name,
            ]),
        ];
    }
}
