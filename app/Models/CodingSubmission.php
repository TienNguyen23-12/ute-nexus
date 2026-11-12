<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CodingSubmissionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodingSubmission extends Model
{
    protected $fillable = [
        'coding_problem_id',
        'user_id',
        'cohort_id',
        'source_code',
        'language',
        'status',
        'execution_time_ms',
        'memory_used_kb',
        'score',
        'log_output',
        'test_results',
        'submitted_at',
    ];

    protected $attributes = [
        'status' => CodingSubmissionStatus::PENDING->value,
        'score' => '0.00',
        'test_results' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'status' => CodingSubmissionStatus::class,
            'execution_time_ms' => 'integer',
            'memory_used_kb' => 'integer',
            'score' => 'decimal:2',
            'test_results' => 'array',
            'submitted_at' => 'datetime',
        ];
    }

    public function codingProblem(): BelongsTo
    {
        return $this->belongsTo(CodingProblem::class, 'coding_problem_id');
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
