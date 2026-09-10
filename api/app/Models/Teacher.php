<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'specialization', 'diploma', 'experience_years',
        'bio', 'phone', 'photo', 'status', 'hire_date'
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        // Some databases/schemas use different columns for publishing/status.
        // Check for commonly used columns and apply a safe filter. If none exist,
        // return the unmodified query to avoid runtime SQL errors.
        try {
            if (\Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), 'status')) {
                return $query->where('status', 'active');
            }
        } catch (\Throwable $e) {
            // ignore schema check failures
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), 'is_published')) {
                return $query->where('is_published', true);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return $query;
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('specialization')->orderByRaw('user_id IS NOT NULL DESC');
    }
}
