<?php

declare(strict_types=1);

use App\Enums\ModerationTaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moderator_attendances', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('moderator_id')->constrained('users')->cascadeOnDelete();
            $table->date('work_date');
            $table->boolean('is_active')->default(true);
            $table->integer('max_daily_minutes')->default(480);
            $table->integer('assigned_tasks_count')->default(0);
            $table->integer('completed_tasks_count')->default(0);
            $table->integer('active_tasks_count')->default(0);
            $table->integer('total_workload_minutes')->default(0);
            $table->timestampTz('check_in_at')->useCurrent();
            $table->timestampTz('check_out_at')->nullable();
            $table->boolean('is_overtime')->default(false);
            $table->timestampTz('ot_check_in_at')->nullable();
            $table->timestampTz('ot_check_out_at')->nullable();
            $table->integer('ot_workload_minutes')->default(0);
            $table->timestamps();

            $table->unique(['moderator_id', 'work_date'], 'uq_mod_date');
        });

        Schema::create('moderation_tasks', function (Blueprint $table): void {
            $table->id();
            $table->string('item_type', 50);
            $table->unsignedBigInteger('item_id');
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('cohort_id')->nullable()->constrained('cohorts')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 30)->default(ModerationTaskStatus::PENDING->value);
            $table->integer('estimated_review_minutes')->default(60);
            $table->timestampTz('assigned_at')->nullable();
            $table->timestampTz('deadline_at')->nullable();
            $table->integer('escalation_level')->default(1);
            $table->foreignId('escalated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('escalation_reason')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->index(['status', 'assigned_to'], 'idx_tasks_queue');
            $table->index('assigned_to', 'idx_tasks_assigned_to');
            $table->index(['item_type', 'item_id'], 'idx_tasks_item');
        });

        Schema::create('payroll_configs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->cascadeOnDelete();
            $table->boolean('is_global')->default(false);
            $table->decimal('instructor_share_percent', 5, 2)->nullable();
            $table->decimal('instructor_rating_bonus_percent', 5, 2)->nullable();
            $table->decimal('instructor_rating_threshold', 4, 2)->nullable();
            $table->decimal('moderator_minute_rate', 12, 2)->nullable();
            $table->decimal('moderator_ot_multiplier', 5, 2)->nullable();
            $table->decimal('moderator_task_bonus', 12, 2)->nullable();
            $table->decimal('moderator_sla_penalty', 12, 2)->nullable();
            $table->decimal('fixed_allowance', 12, 2)->default(0);
            $table->string('note', 500)->nullable();
            $table->timestamps();
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE moderation_tasks ADD CONSTRAINT chk_not_self_review CHECK (assigned_to IS NULL OR author_id <> assigned_to)');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE moderation_tasks DROP CONSTRAINT IF EXISTS chk_not_self_review');
        }

        Schema::dropIfExists('payroll_configs');
        Schema::dropIfExists('moderation_tasks');
        Schema::dropIfExists('moderator_attendances');
    }
};
