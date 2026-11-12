<?php

declare(strict_types=1);

use App\Enums\CohortRole;
use App\Enums\ShowScoreType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cohort_members', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('cohort_id')->constrained('cohorts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role_in_cohort', 30)->default(CohortRole::STUDENT->value);
            $table->timestampTz('enrolled_at')->useCurrent();
            $table->decimal('process_grade', 5, 2)->nullable();
            $table->decimal('final_exam_grade', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->timestampTz('graded_at')->nullable();
            $table->boolean('is_passed')->default(false);
            $table->text('certificate_url')->nullable();
            $table->integer('rating')->nullable();
            $table->text('review_comment')->nullable();
            $table->timestampTz('reviewed_at')->nullable();
            $table->foreignId('last_lesson_id')->nullable()->constrained('lessons')->nullOnDelete();
            $table->timestampTz('last_accessed_at')->nullable();
            $table->timestamps();

            $table->unique(['cohort_id', 'user_id'], 'uq_cohort_user');
            $table->index('user_id', 'idx_cohort_members_user');
            $table->index('cohort_id', 'idx_cohort_members_cohort');
            $table->index('last_lesson_id', 'idx_cohort_members_last_lesson');
        });

        Schema::create('cohort_schedules', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('cohort_id')->constrained('cohorts')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->timestampTz('unlock_at');
            $table->timestampTz('deadline_at')->nullable();
            $table->string('show_score_type', 30)->default(ShowScoreType::IMMEDIATELY->value);
            $table->boolean('is_score_published')->default(true);
            $table->boolean('allow_review_answers')->default(true);
            $table->timestampTz('review_available_at')->nullable();
            $table->timestamps();

            $table->unique(['cohort_id', 'lesson_id'], 'uq_cohort_lesson');
        });

        Schema::create('enrollments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->timestampTz('enrolled_at')->useCurrent();
            $table->float('progress')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestampTz('completed_at')->nullable();
            $table->decimal('average_grade', 5, 2)->nullable();
            $table->text('certificate_url')->nullable();
            $table->integer('rating')->nullable();
            $table->text('review_comment')->nullable();
            $table->timestampTz('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id'], 'uq_enrollment_user_course');
        });

        Schema::create('lesson_completions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('cohort_id')->constrained('cohorts')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestampTz('completed_at')->useCurrent();
            $table->timestamps();

            $table->unique(['cohort_id', 'lesson_id', 'user_id'], 'uq_lesson_cohort_user');
            $table->index(['cohort_id', 'user_id'], 'idx_lesson_completions_cohort_user');
            $table->index('lesson_id', 'idx_lesson_completions_lesson');
        });

        Schema::create('lesson_notes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->foreignId('cohort_id')->nullable()->constrained('cohorts')->cascadeOnDelete();
            $table->integer('timestamp_seconds')->nullable();
            $table->text('content');
            $table->timestamps();

            $table->index(['user_id', 'lesson_id'], 'idx_lesson_notes_user_lesson');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_notes');
        Schema::dropIfExists('lesson_completions');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('cohort_schedules');
        Schema::dropIfExists('cohort_members');
    }
};
