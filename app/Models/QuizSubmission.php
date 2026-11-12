<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizSubmission extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'cohort_id',
        'started_at',
        'submitted_at',
        'score',
        'is_passed',
        'is_late',
        'status',
        'answers',
    ];

    protected $attributes = [
        'is_passed' => false,
        'is_late' => false,
        'status' => SubmissionStatus::SUBMITTED->value,
        'answers' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'score' => 'decimal:2',
            'is_passed' => 'boolean',
            'is_late' => 'boolean',
            'status' => SubmissionStatus::class,
            'answers' => 'array',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id');
    }
}
