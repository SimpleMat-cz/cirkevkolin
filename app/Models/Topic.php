<?php

namespace App\Models;

use Database\Factories\TopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Topic extends Model
{
    /** @use HasFactory<TopicFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function sermons(): BelongsToMany
    {
        return $this->belongsToMany(Sermon::class);
    }
}
