<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\PublicStorageUrl;

class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'body' => $this->when(isset($this->body), $this->body),
            'cover_url' => PublicStorageUrl::make($this->cover_path, $request),
            'event_date' => $this->event_date?->toDateString(),
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category?->id,
                'slug' => $this->category?->slug,
                'name' => $this->category?->name,
            ]),
            'images' => $this->whenLoaded('images', fn () => $this->images->map(fn ($image) => [
                'id' => $image->id,
                'url' => PublicStorageUrl::make($image->image_path, $request),
                'alt_text' => $image->alt_text,
            ])),
        ];
    }
}
