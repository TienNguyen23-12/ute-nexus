<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ShowScoreType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CohortSchedule extends Model
{
    protected $fillable = [
        'cohort_id',
        'lesson_id',
        'unlock_at',
        'deadline_at',
        'show_score_type',
        'is_score_published',
        'allow_review_answers',
        'review_available_at',
    ];

    protected $attributes = [
        'show_score_type' => ShowScoreType::IMMEDIATELY->value,
        'is_score_published' => true,
        'allow_review_answers' => true,
    ];

    protected function casts(): array
    {
        return [
            'unlock_at' => 'datetime',
            'deadline_at' => 'datetime',
            'show_score_type' => ShowScoreType::class,
            'is_score_published' => 'boolean',
            'allow_review_answers' => 'boolean',
            'review_available_at' => 'datetime',
        ];
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
}
