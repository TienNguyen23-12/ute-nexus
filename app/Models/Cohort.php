<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CohortModerationStatus;
use App\Enums\CohortStatus;
use App\Enums\GradingPolicy;
use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cohort extends Model
{
    protected $fillable = [
        'course_id',
        'created_by',
        'code',
        'name',
        'enrollment_start',
        'enrollment_end',
        'study_start',
        'study_end',
        'max_capacity',
        'current_enrolled',
        'price',
        'status',
        'moderation_status',
        'visibility',
        'thumbnail_url',
        'description',
        'objectives',
        'announcement_title',
        'announcement_content',
        'order_index',
        'grading_policy',
        'process_weight',
        'final_weight',
        'final_lesson_id',
        'min_passing_grade',
        'min_final_exam_score',
        'is_grades_published',
    ];

    protected $attributes = [
        'max_capacity' => 50,
        'current_enrolled' => 0,
        'price' => '0.00',
        'status' => CohortStatus::UPCOMING->value,
        'moderation_status' => CohortModerationStatus::DRAFT->value,
        'visibility' => Visibility::PUBLIC->value,
        'order_index' => 1,
        'grading_policy' => GradingPolicy::PROGRESS_BASED->value,
        'process_weight' => 50,
        'final_weight' => 50,
        'min_passing_grade' => '5.00',
        'min_final_exam_score' => '3.00',
        'is_grades_published' => false,
    ];

    protected function casts(): array
    {
        return [
            'enrollment_start' => 'datetime',
            'enrollment_end' => 'datetime',
            'study_start' => 'datetime',
            'study_end' => 'datetime',
            'max_capacity' => 'integer',
            'current_enrolled' => 'integer',
            'price' => 'decimal:2',
            'status' => CohortStatus::class,
            'moderation_status' => CohortModerationStatus::class,
            'visibility' => Visibility::class,
            'order_index' => 'integer',
            'grading_policy' => GradingPolicy::class,
            'process_weight' => 'integer',
            'final_weight' => 'integer',
            'min_passing_grade' => 'decimal:2',
            'min_final_exam_score' => 'decimal:2',
            'is_grades_published' => 'boolean',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function finalLesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'final_lesson_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'cohort_id')->orderBy('order_index');
    }

    public function members(): HasMany
    {
        return $this->hasMany(CohortMember::class, 'cohort_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(CohortSchedule::class, 'cohort_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(CohortMessage::class, 'cohort_id');
    }

    public function lessonCompletions(): HasMany
    {
        return $this->hasMany(LessonCompletion::class, 'cohort_id');
    }
}
