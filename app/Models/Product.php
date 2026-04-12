<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saving(function (self $product): void {
            if (blank($product->name)) {
                return;
            }

            if (blank($product->slug) || $product->isDirty('name')) {
                $product->slug = self::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    public const FAMILY_OPTIONS = [
        'CURTAIN' => 'CURTAIN',
        'BLINDS' => 'BLINDS',
        'RAILING' => 'RAILING',
        'HOOK' => 'HOOK',
        'MOTORIZED' => 'MOTORIZED',
    ];

    public const SECTION_OPTIONS = [
        'curtain_catalogue' => 'Curtain Catalogue',
        'curtain_types' => 'Curtain Types',
        'healing_styles' => 'Healing Styles',
        'curtain_colors' => 'Curtain Colors',
        'curtain_measure_quote' => 'Measure & Quote (Curtain)',
        'blinds_catalogue' => 'Blinds Catalogue',
        'blinds_types' => 'Blinds Types',
        'blinds_measure_quote' => 'Measure & Quote (Blinds)',
        'railing_catalogue' => 'Railing Catalogue',
        'railing_types' => 'Railing Types',
        'railing_colors' => 'Railing Colors',
        'hook_catalogue' => 'Hook Catalogue',
        'motorized_hook' => 'Motorized Hook',
        'motorized_catalogue' => 'Motorized Catalogue',
    ];

    protected $fillable = [
        'family',
        'section',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'image',
        'sub_images',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'price' => 'decimal:2',
            'sub_images' => 'array',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        return self::resolveImageUrl($this->image);
    }

    public function getGalleryImageUrlsAttribute(): array
    {
        return collect($this->sub_images ?? [])
            ->take(5)
            ->map(fn($path): ?string => self::resolveImageUrl($path))
            ->filter()
            ->values()
            ->all();
    }

    protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug !== '' ? $baseSlug : 'product';
        $counter = 2;

        while (static::query()
            ->when($ignoreId, fn($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = ($baseSlug !== '' ? $baseSlug : 'product') . '-' . $counter;
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
