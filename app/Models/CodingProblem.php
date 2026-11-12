<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CodingProblem extends Model
{
    protected $fillable = [
        'lesson_id',
        'title',
        'statement_markdown',
        'allowed_languages',
        'time_limit_ms',
        'memory_limit_mb',
        'starter_code',
        'show_hidden_test_details',
        'test_cases',
    ];

    protected $attributes = [
        'allowed_languages' => 'JAVA,PYTHON,CPP',
        'time_limit_ms' => 2000,
        'memory_limit_mb' => 256,
        'show_hidden_test_details' => false,
        'test_cases' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'time_limit_ms' => 'integer',
            'memory_limit_mb' => 'integer',
            'show_hidden_test_details' => 'boolean',
            'test_cases' => 'array',
        ];
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(CodingSubmission::class, 'coding_problem_id');
    }
}
