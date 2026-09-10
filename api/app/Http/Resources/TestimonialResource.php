<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author_name' => $this->author_name,
            'author_role' => $this->author_role,
            'content' => $this->content,
            'photo_url' => $this->photo_path ? Storage::disk('public')->url($this->photo_path) : null,
            'rating' => $this->rating,
            'sort_order' => $this->sort_order,
            'is_published' => $this->is_published,
        ];
    }
}
