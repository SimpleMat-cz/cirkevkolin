<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'group', 'label', 'value', 'type', 'help', 'sort'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site_settings.all'));
        static::deleted(fn () => Cache::forget('site_settings.all'));
    }

    /**
     * @return array<string, string|null>
     */
    public static function allAsKeyValue(): array
    {
        /** @var array<string, string|null> $cached */
        $cached = Cache::rememberForever('site_settings.all', function (): array {
            return self::query()->pluck('value', 'key')->all();
        });

        return $cached;
    }

    public static function value(string $key, ?string $default = null): ?string
    {
        return self::allAsKeyValue()[$key] ?? $default;
    }
}
