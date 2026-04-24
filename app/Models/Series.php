<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    /** @use HasFactory<\Database\Factories\SeriesFactory> */
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function sermons(): HasMany
    {
        return $this->hasMany(Sermon::class);
    }
}
