<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CohortRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CohortMember extends Model
{
    protected $fillable = [
        'cohort_id',
        'user_id',
        'role_in_cohort',
        'enrolled_at',
        'process_grade',
        'final_exam_grade',
        'final_grade',
        'graded_at',
        'is_passed',
        'certificate_url',
        'rating',
        'review_comment',
        'reviewed_at',
        'last_lesson_id',
        'last_accessed_at',
    ];

    protected $attributes = [
        'role_in_cohort' => CohortRole::STUDENT->value,
        'is_passed' => false,
    ];

    protected function casts(): array
    {
        return [
            'role_in_cohort' => CohortRole::class,
            'enrolled_at' => 'datetime',
            'process_grade' => 'decimal:2',
            'final_exam_grade' => 'decimal:2',
            'final_grade' => 'decimal:2',
            'graded_at' => 'datetime',
            'is_passed' => 'boolean',
            'rating' => 'integer',
            'reviewed_at' => 'datetime',
            'last_accessed_at' => 'datetime',
        ];
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lastLesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'last_lesson_id');
    }
}
