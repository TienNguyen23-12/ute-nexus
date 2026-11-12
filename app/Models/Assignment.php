<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    protected $fillable = [
        'lesson_id',
        'title',
        'instruction',
        'attachment_url',
        'max_score',
        'passing_score',
        'allow_file_submission',
        'allow_text_submission',
        'allowed_file_types',
        'max_file_size_mb',
        'allow_late_submission',
    ];

    protected $attributes = [
        'max_score' => '10.00',
        'passing_score' => '5.00',
        'allow_file_submission' => true,
        'allow_text_submission' => true,
        'allowed_file_types' => 'pdf,doc,docx,zip,rar,txt',
        'max_file_size_mb' => 20,
        'allow_late_submission' => true,
    ];

    protected function casts(): array
    {
        return [
            'max_score' => 'decimal:2',
            'passing_score' => 'decimal:2',
            'allow_file_submission' => 'boolean',
            'allow_text_submission' => 'boolean',
            'max_file_size_mb' => 'integer',
            'allow_late_submission' => 'boolean',
        ];
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class, 'assignment_id');
    }
}
