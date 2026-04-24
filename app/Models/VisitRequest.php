<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitRequest extends Model
{
    /** @use HasFactory<\Database\Factories\VisitRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'people_count', 'note', 'planned_visit_date', 'was_contacted',
    ];

    protected function casts(): array
    {
        return [
            'planned_visit_date' => 'date',
            'was_contacted' => 'boolean',
        ];
    }
}
