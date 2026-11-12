<?php

declare(strict_types=1);

use App\Enums\CodingSubmissionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coding_problems', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('lesson_id')->unique()->constrained('lessons')->cascadeOnDelete();
            $table->string('title', 255);
            $table->text('statement_markdown');
            $table->string('allowed_languages', 255)->default('JAVA,PYTHON,CPP');
            $table->integer('time_limit_ms')->default(2000);
            $table->integer('memory_limit_mb')->default(256);
            $table->text('starter_code')->nullable();
            $table->boolean('show_hidden_test_details')->default(false);
            $table->jsonb('test_cases')->default('[]');
            $table->timestamps();

            $table->index('lesson_id', 'idx_coding_problems_lesson');
        });

        Schema::create('coding_submissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('coding_problem_id')->constrained('coding_problems')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('cohort_id')->constrained('cohorts')->cascadeOnDelete();
            $table->text('source_code');
            $table->string('language', 30);
            $table->string('status', 30)->default(CodingSubmissionStatus::PENDING->value);
            $table->integer('execution_time_ms')->nullable();
            $table->integer('memory_used_kb')->nullable();
            $table->decimal('score', 5, 2)->default(0);
            $table->text('log_output')->nullable();
            $table->jsonb('test_results')->default('[]');
            $table->timestampTz('submitted_at')->useCurrent();
            $table->timestamps();

            $table->index(['cohort_id', 'user_id', 'coding_problem_id'], 'idx_coding_submissions_user');
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE INDEX idx_coding_problems_test_cases_gin ON coding_problems USING gin (test_cases)');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS idx_coding_problems_test_cases_gin');
        }

        Schema::dropIfExists('coding_submissions');
        Schema::dropIfExists('coding_problems');
    }
};
