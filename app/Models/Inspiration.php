<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Inspiration extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saving(function (self $inspiration): void {
            if (blank($inspiration->title)) {
                return;
            }

            if (blank($inspiration->slug) || $inspiration->isDirty('title')) {
                $inspiration->slug = self::generateUniqueSlug($inspiration->title, $inspiration->id);
            }
        });
    }

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug !== '' ? $baseSlug : 'inspiration';
        $counter = 2;

        while (static::query()
            ->when($ignoreId, fn($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = ($baseSlug !== '' ? $baseSlug : 'inspiration') . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
