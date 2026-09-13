<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ActualityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = $this->image_path;
        if ($imageUrl && str_starts_with($imageUrl, '/')) {
            $parts = explode('/', ltrim($imageUrl, '/'));
            $encodedPath = implode('/', array_map('rawurlencode', $parts));
            $appUrl = rtrim(config('app.url') ?: env('APP_URL', 'http://127.0.0.1:8000'), '/');
            $imageUrl = $appUrl . '/' . $encodedPath;
        } elseif ($imageUrl) {
            $imageUrl = Storage::disk('public')->url($imageUrl);
        }

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
