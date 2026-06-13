<?php

namespace App\Models;

use Database\Factories\LeaderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Leader extends Model
{
    /** @use HasFactory<LeaderFactory> */
    use HasFactory;

    /** Stránky, ke kterým lze vedoucí přiřadit. */
    public const PAGES = [
        'nedelni-setkani' => 'Nedělní setkání',
        'kidztown' => 'Kidztown',
        'wyldlife' => 'WyldLife',
        'skupinky' => 'Skupinky',
        'young-life' => 'Young Life',
        'kavarna' => 'Kavárna',
        'business' => 'Business setkání',
        'kdo-jsme' => 'Kdo jsme',
    ];

    protected $fillable = [
        'name', 'role', 'phone', 'email', 'photo_path',
        'page_slug', 'sort', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Disk pro fotky: na Vercelu S3 (Supabase Storage), lokálně veřejný disk
     * (storage:link) — výchozí „local" disk je privátní a fotky by nebyly vidět.
     */
    public static function mediaDisk(): string
    {
        $default = config('filesystems.default');

        return $default === 'local' ? 'public' : $default;
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->photo_path
                ? Storage::disk(self::mediaDisk())->url($this->photo_path)
                : null,
        );
    }

    /**
     * @param  Builder<Leader>  $query
     * @return Builder<Leader>
     */
    public function scopeForPage(Builder $query, string $pageSlug): Builder
    {
        return $query
            ->where('page_slug', $pageSlug)
            ->where('is_active', true)
            ->orderBy('sort')
            ->orderBy('name');
    }
}
