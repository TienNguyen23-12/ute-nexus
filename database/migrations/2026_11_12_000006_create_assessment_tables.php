<?php

declare(strict_types=1);

use App\Enums\SubmissionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('lesson_id')->unique()->constrained('lessons')->cascadeOnDelete();
            $table->string('title', 255);
            $table->integer('duration_minutes')->default(15);
            $table->decimal('passing_score', 5, 2)->default(5.00);
            $table->integer('max_attempts')->default(1);
            $table->boolean('shuffle_questions')->default(true);
            $table->boolean('allow_review')->default(true);
            $table->boolean('allow_late_submission')->default(true);
            $table->text('exam_rules')->nullable();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('content');
            $table->string('question_type', 30);
            $table->decimal('points', 5, 2)->default(1.00);
            $table->text('explanation')->nullable();
            $table->jsonb('options')->default('[]');
            $table->integer('order_index')->default(1);
            $table->timestamps();

            $table->index('quiz_id', 'idx_questions_quiz');
        });

        Schema::create('quiz_submissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('cohort_id')->constrained('cohorts')->cascadeOnDelete();
            $table->timestampTz('started_at')->useCurrent();
            $table->timestampTz('submitted_at')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->boolean('is_passed')->default(false);
            $table->boolean('is_late')->default(false);
            $table->string('status', 30)->default(SubmissionStatus::SUBMITTED->value);
            $table->jsonb('answers')->default('[]');
            $table->timestamps();

            $table->index(['user_id', 'quiz_id', 'cohort_id'], 'idx_submissions_user_quiz');
        });

        Schema::create('assignments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('lesson_id')->unique()->constrained('lessons')->cascadeOnDelete();
            $table->string('title', 255);
            $table->text('instruction')->nullable();
            $table->text('attachment_url')->nullable();
            $table->decimal('max_score', 5, 2)->default(10.00);
            $table->decimal('passing_score', 5, 2)->default(5.00);
            $table->boolean('allow_file_submission')->default(true);
            $table->boolean('allow_text_submission')->default(true);
            $table->string('allowed_file_types', 255)->default('pdf,doc,docx,zip,rar,txt');
            $table->integer('max_file_size_mb')->default(20);
            $table->boolean('allow_late_submission')->default(true);
            $table->timestamps();
        });

        Schema::create('assignment_submissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('cohort_id')->nullable()->constrained('cohorts')->cascadeOnDelete();
            $table->text('submission_text')->nullable();
            $table->text('file_url')->nullable();
            $table->string('file_name', 255)->nullable();
            $table->bigInteger('file_size_bytes')->nullable();
            $table->boolean('is_late')->default(false);
            $table->string('status', 30)->default(SubmissionStatus::SUBMITTED->value);
            $table->decimal('score', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampTz('graded_at')->nullable();
            $table->timestampTz('submitted_at')->useCurrent();
            $table->timestamps();

            $table->unique(['assignment_id', 'user_id', 'cohort_id'], 'uq_assignment_user_cohort');
            $table->index(['cohort_id', 'user_id', 'assignment_id'], 'idx_assignment_submissions_user');
            $table->index('assignment_id', 'idx_assignment_submissions_assignment');
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE INDEX idx_questions_options_gin ON questions USING gin (options)');
            DB::statement('CREATE INDEX idx_submissions_answers_gin ON quiz_submissions USING gin (answers)');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS idx_submissions_answers_gin');
            DB::statement('DROP INDEX IF EXISTS idx_questions_options_gin');
        }

        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('quiz_submissions');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
    }
};
