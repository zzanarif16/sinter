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
        'sub_images',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'sub_images' => 'array',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        return self::resolveImageUrl($this->image);
    }

    public function getGalleryItemsAttribute(): array
    {
        return collect($this->sub_images ?? [])
            ->take(10)
            ->map(function (mixed $item): ?array {
                if (is_string($item)) {
                    $url = self::resolveImageUrl($item);

                    return $url ? [
                        'image_url' => $url,
                        'detail' => null,
                    ] : null;
                }

                if (! is_array($item)) {
                    return null;
                }

                $path = $item['image'] ?? $item['path'] ?? null;
                $url = is_string($path) ? self::resolveImageUrl($path) : null;

                if (! $url) {
                    return null;
                }

                $detail = $item['detail'] ?? $item['caption'] ?? null;

                return [
                    'image_url' => $url,
                    'detail' => is_string($detail) && trim($detail) !== '' ? trim($detail) : null,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    public function getGalleryImageUrlsAttribute(): array
    {
        return collect($this->gallery_items)
            ->pluck('image_url')
            ->filter()
            ->values()
            ->all();
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

    protected static function resolveImageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
