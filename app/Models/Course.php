<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'code',
        'title',
        'slug',
        'headline',
        'description',
        'thumbnail_url',
        'level',
        'status',
        'price',
        'category_id',
        'created_by',
        'objectives',
        'requirements',
    ];

    protected $attributes = [
        'level' => CourseLevel::ALL_LEVELS->value,
        'status' => CourseStatus::DRAFT->value,
        'objectives' => '[]',
        'requirements' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'level' => CourseLevel::class,
            'status' => CourseStatus::class,
            'price' => 'decimal:2',
            'objectives' => 'array',
            'requirements' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cohorts(): HasMany
    {
        return $this->hasMany(Cohort::class, 'course_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'course_id')->orderBy('order_index');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'course_id');
    }
}
