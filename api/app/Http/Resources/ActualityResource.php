<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\PublicStorageUrl;

class ActualityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = PublicStorageUrl::make($this->image_path, $request);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category,
            'description' => $this->description,
            'image_url' => $imageUrl,
            'sort_order' => $this->sort_order,
            'is_visible' => $this->is_visible,
            'is_pinned' => $this->is_pinned,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
