<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'level',
        'description',
        'objectives',
        'requirements',
        'image',
        'icon',
        'duration_years',
        'price',
        'order',
        'is_active',
        'title',
        'summary',
        'image_path',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'order' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function getTitleAttribute($value): mixed
    {
        return $value ?? $this->attributes['name'] ?? null;
    }

    public function getSummaryAttribute($value): mixed
    {
        return $value ?? $this->attributes['description'] ?? null;
    }

    public function getSortOrderAttribute($value): int
    {
        return $value ?? $this->attributes['order'] ?? 0;
    }

    public function getIsPublishedAttribute($value): bool
    {
        return $value ?? $this->attributes['is_active'] ?? false;
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProgramFeature::class)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function (Builder $query): void {
            $query->where('is_published', true);

            if (Schema::hasColumn((new self())->getTable(), 'is_active')) {
                $query->orWhere('is_active', true);
            }
        });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('sort_order')->orderBy('name')->orderBy('title');
    }

}
