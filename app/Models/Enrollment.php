<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'progress',
        'is_completed',
        'completed_at',
        'average_grade',
        'certificate_url',
        'rating',
        'review_comment',
        'reviewed_at',
    ];

    protected $attributes = [
        'progress' => 0.0,
        'is_completed' => false,
    ];

    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
            'progress' => 'float',
            'is_completed' => 'boolean',
            'completed_at' => 'datetime',
            'average_grade' => 'decimal:2',
            'rating' => 'integer',
            'reviewed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
