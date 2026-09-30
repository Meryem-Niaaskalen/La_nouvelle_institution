<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\PublicStorageUrl;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author_name' => $this->author_name,
            'author_role' => $this->author_role,
            'content' => $this->content,
            'photo_url' => PublicStorageUrl::make($this->photo_path, $request),
            'rating' => $this->rating,
            'sort_order' => $this->sort_order,
            'is_published' => $this->is_published,
        ];
    }
}
