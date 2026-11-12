<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = [
        'lesson_id',
        'title',
        'duration_minutes',
        'passing_score',
        'max_attempts',
        'shuffle_questions',
        'allow_review',
        'allow_late_submission',
        'exam_rules',
    ];

    protected $attributes = [
        'duration_minutes' => 15,
        'passing_score' => '5.00',
        'max_attempts' => 1,
        'shuffle_questions' => true,
        'allow_review' => true,
        'allow_late_submission' => true,
    ];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'passing_score' => 'decimal:2',
            'max_attempts' => 'integer',
            'shuffle_questions' => 'boolean',
            'allow_review' => 'boolean',
            'allow_late_submission' => 'boolean',
        ];
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'quiz_id')->orderBy('order_index');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(QuizSubmission::class, 'quiz_id');
    }
}
