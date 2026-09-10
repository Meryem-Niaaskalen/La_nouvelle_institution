<?php

namespace App\Models;

use App\Enums\ContactMessageSource;
use App\Enums\ContactMessageStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'source',
        'status',
        'desired_level',
    ];

    protected function casts(): array
    {
        return [
            'source' => ContactMessageSource::class,
            'status' => ContactMessageStatus::class,
        ];
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('status', ContactMessageStatus::New);
    }
}
