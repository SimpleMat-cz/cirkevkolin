<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'slug',
        'hero_eyebrow', 'hero_title', 'hero_title_accent', 'hero_accent_color', 'hero_description',
        'body', 'meta_title', 'meta_description', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'body' => 'array',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn (Page $page) => Cache::forget("page.{$page->slug}"));
        static::deleted(fn (Page $page) => Cache::forget("page.{$page->slug}"));
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public static function findBySlug(string $slug): ?self
    {
        $attributes = Cache::rememberForever("page.{$slug}", function () use ($slug): ?array {
            $page = self::query()->where('slug', $slug)->first();

            return $page?->getAttributes();
        });

        if ($attributes === null) {
            return null;
        }

        return (new self)->newFromBuilder($attributes);
    }
}
