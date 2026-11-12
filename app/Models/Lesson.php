<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LessonStatus;
use App\Enums\LessonType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lesson extends Model
{
    protected $fillable = [
        'section_id',
        'title',
        'lesson_type',
        'order_index',
        'is_free_preview',
        'video_url',
        'duration_seconds',
        'document_content',
        'asset_url',
        'is_public_for_cohorts',
        'status',
    ];

    protected $attributes = [
        'order_index' => 1,
        'is_free_preview' => false,
        'duration_seconds' => 0,
        'is_public_for_cohorts' => false,
        'status' => LessonStatus::DRAFT->value,
    ];

    protected function casts(): array
    {
        return [
            'lesson_type' => LessonType::class,
            'order_index' => 'integer',
            'is_free_preview' => 'boolean',
            'duration_seconds' => 'integer',
            'is_public_for_cohorts' => 'boolean',
            'status' => LessonStatus::class,
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class, 'lesson_id');
    }

    public function assignment(): HasOne
    {
        return $this->hasOne(Assignment::class, 'lesson_id');
    }

    public function codingProblem(): HasOne
    {
        return $this->hasOne(CodingProblem::class, 'lesson_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(CohortSchedule::class, 'lesson_id');
    }

    public function completions(): HasMany
    {
        return $this->hasMany(LessonCompletion::class, 'lesson_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(LessonNote::class, 'lesson_id');
    }
}
