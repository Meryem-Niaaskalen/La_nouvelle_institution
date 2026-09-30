<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\PublicStorageUrl;

class TeacherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'title' => $this->title,
            'subject' => $this->subject,
            'bio' => $this->bio,
            'photo_url' => PublicStorageUrl::make($this->photo_path, $request),
            'sort_order' => $this->sort_order,
            'is_published' => $this->is_published,
        ];
    }
}
