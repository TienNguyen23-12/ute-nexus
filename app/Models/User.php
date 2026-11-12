<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AuthProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'phone_number',
        'avatar_url',
        'is_active',
        'auth_provider',
        'balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'is_active' => true,
        'auth_provider' => AuthProvider::LOCAL->value,
        'balance' => '0.00',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'auth_provider' => AuthProvider::class,
            'balance' => 'decimal:2',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withPivot('assigned_at');
    }

    public function createdCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    public function createdCohorts(): HasMany
    {
        return $this->hasMany(Cohort::class, 'created_by');
    }

    public function instructorAssets(): HasMany
    {
        return $this->hasMany(InstructorAsset::class, 'instructor_id');
    }

    public function cohortMemberships(): HasMany
    {
        return $this->hasMany(CohortMember::class, 'user_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'user_id');
    }

    public function lessonCompletions(): HasMany
    {
        return $this->hasMany(LessonCompletion::class, 'user_id');
    }

    public function lessonNotes(): HasMany
    {
        return $this->hasMany(LessonNote::class, 'user_id');
    }

    public function quizSubmissions(): HasMany
    {
        return $this->hasMany(QuizSubmission::class, 'user_id');
    }

    public function assignmentSubmissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class, 'user_id');
    }

    public function codingSubmissions(): HasMany
    {
        return $this->hasMany(CodingSubmission::class, 'user_id');
    }

    public function moderatorAttendances(): HasMany
    {
        return $this->hasMany(ModeratorAttendance::class, 'moderator_id');
    }

    public function authoredModerationTasks(): HasMany
    {
        return $this->hasMany(ModerationTask::class, 'author_id');
    }

    public function assignedModerationTasks(): HasMany
    {
        return $this->hasMany(ModerationTask::class, 'assigned_to');
    }

    public function payrollConfig(): HasOne
    {
        return $this->hasOne(PayrollConfig::class, 'user_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'user_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function sentCohortMessages(): HasMany
    {
        return $this->hasMany(CohortMessage::class, 'sender_id');
    }

    public function receivedNotifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'recipient_id');
    }

    public function sentNotifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'sender_id');
    }
}
