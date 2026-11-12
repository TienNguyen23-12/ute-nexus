<?php

declare(strict_types=1);

use App\Enums\CohortModerationStatus;
use App\Enums\CohortStatus;
use App\Enums\GradingPolicy;
use App\Enums\LessonStatus;
use App\Enums\Visibility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cohorts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name', 255);
            $table->timestampTz('enrollment_start')->nullable();
            $table->timestampTz('enrollment_end')->nullable();
            $table->timestampTz('study_start')->nullable();
            $table->timestampTz('study_end')->nullable();
            $table->integer('max_capacity')->default(50);
            $table->integer('current_enrolled')->default(0);
            $table->decimal('price', 12, 2)->default(0);
            $table->string('status', 30)->default(CohortStatus::UPCOMING->value);
            $table->string('moderation_status', 30)->default(CohortModerationStatus::DRAFT->value);
            $table->string('visibility', 30)->default(Visibility::PUBLIC->value);
            $table->text('thumbnail_url')->nullable();
            $table->text('description')->nullable();
            $table->text('objectives')->nullable();
            $table->string('announcement_title', 255)->nullable();
            $table->text('announcement_content')->nullable();
            $table->integer('order_index')->default(1);
            $table->string('grading_policy', 30)->default(GradingPolicy::PROGRESS_BASED->value);
            $table->integer('process_weight')->default(50);
            $table->integer('final_weight')->default(50);
            $table->unsignedBigInteger('final_lesson_id')->nullable();
            $table->decimal('min_passing_grade', 5, 2)->default(5.00);
            $table->decimal('min_final_exam_score', 5, 2)->default(3.00);
            $table->boolean('is_grades_published')->default(false);
            $table->timestamps();

            $table->index('course_id', 'idx_cohorts_course');
            $table->index('created_by', 'idx_cohorts_creator');
            $table->index('visibility', 'idx_cohorts_visibility');
        });

        Schema::create('sections', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses')->cascadeOnDelete();
            $table->foreignId('cohort_id')->nullable()->constrained('cohorts')->cascadeOnDelete();
            $table->string('title', 255);
            $table->integer('order_index')->default(1);
            $table->timestamps();

            $table->index(['course_id', 'order_index'], 'idx_sections_course');
            $table->index('cohort_id', 'idx_sections_cohort');
        });

        Schema::create('lessons', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->string('title', 255);
            $table->string('lesson_type', 30);
            $table->integer('order_index')->default(1);
            $table->boolean('is_free_preview')->default(false);
            $table->text('video_url')->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->text('document_content')->nullable();
            $table->text('asset_url')->nullable();
            $table->boolean('is_public_for_cohorts')->default(false);
            $table->string('status', 30)->default(LessonStatus::DRAFT->value);
            $table->timestamps();

            $table->index(['section_id', 'order_index'], 'idx_lessons_section');
        });

        Schema::table('cohorts', function (Blueprint $table): void {
            $table->foreign('final_lesson_id')->references('id')->on('lessons')->nullOnDelete();
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE cohorts ADD CONSTRAINT chk_enrollment_period CHECK (enrollment_start IS NULL OR enrollment_end IS NULL OR enrollment_start < enrollment_end)');
            DB::statement('ALTER TABLE cohorts ADD CONSTRAINT chk_study_period CHECK (study_start IS NULL OR study_end IS NULL OR study_start < study_end)');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE cohorts DROP CONSTRAINT IF EXISTS chk_enrollment_period');
            DB::statement('ALTER TABLE cohorts DROP CONSTRAINT IF EXISTS chk_study_period');
        }

        Schema::table('cohorts', function (Blueprint $table): void {
            $table->dropForeign(['final_lesson_id']);
        });

        Schema::dropIfExists('lessons');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('cohorts');
    }
};
