<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'starts_at', 'ends_at',
        'rrule', 'category', 'location', 'image_url', 'has_registration', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'has_registration' => 'boolean',
            'is_published' => 'boolean',
        ];
    }
}
