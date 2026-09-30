<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\PublicStorageUrl;

class ProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'level' => $this->level,
            'summary' => $this->summary,
            'description' => $this->when($request->routeIs('*.show') || isset($this->description), $this->description),
            'icon' => $this->icon,
            'image_url' => PublicStorageUrl::make($this->image_path, $request),
            'sort_order' => $this->sort_order,
            'is_published' => $this->is_published,
            'features' => [],
        ];
    }
}
