<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id',
        'user_id',
        'cohort_id',
        'submission_text',
        'file_url',
        'file_name',
        'file_size_bytes',
        'is_late',
        'status',
        'score',
        'feedback',
        'graded_by',
        'graded_at',
        'submitted_at',
    ];

    protected $attributes = [
        'is_late' => false,
        'status' => SubmissionStatus::SUBMITTED->value,
    ];

    protected function casts(): array
    {
        return [
            'file_size_bytes' => 'integer',
            'is_late' => 'boolean',
            'status' => SubmissionStatus::class,
            'score' => 'decimal:2',
            'graded_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id');
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}
