<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\PublicStorageUrl;

class GalleryImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = PublicStorageUrl::make($this->image, $request);
        $thumbnailUrl = PublicStorageUrl::make($this->thumbnail, $request);

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
