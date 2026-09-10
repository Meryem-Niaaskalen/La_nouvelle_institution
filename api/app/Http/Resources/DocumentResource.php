<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category instanceof \BackedEnum ? $this->category->value : $this->category,
            'file_url' => Storage::disk('public')->url($this->file_path),
            'sort_order' => $this->sort_order,
            'is_published' => $this->is_published,
        ];
    }
}
