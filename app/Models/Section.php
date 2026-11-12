<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = [
        'course_id',
        'cohort_id',
        'title',
        'order_index',
    ];

    protected $attributes = [
        'order_index' => 1,
    ];

    protected function casts(): array
    {
        return [
            'order_index' => 'integer',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'section_id')->orderBy('order_index');
    }
}
