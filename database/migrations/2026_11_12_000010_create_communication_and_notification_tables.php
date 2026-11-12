<?php

declare(strict_types=1);

use App\Enums\CohortMessageType;
use App\Enums\NotificationCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cohort_messages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('cohort_id')->constrained('cohorts')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->string('message_type', 30)->default(CohortMessageType::TEXT->value);
            $table->boolean('is_deleted_for_all')->default(false);
            $table->unsignedBigInteger('deleted_by_user_id')->nullable();
            $table->text('hidden_for_user_ids')->nullable();
            $table->timestamps();

            $table->index(['cohort_id', 'created_at'], 'idx_messages_cohort');
        });

        Schema::create('notifications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title', 255);
            $table->text('content');
            $table->string('type', 50);
            $table->string('category', 30)->default(NotificationCategory::ACADEMIC->value);
            $table->string('action_url', 500)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_type', 50)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestampTz('read_at')->nullable();
            $table->timestamps();

            $table->index(['recipient_id', 'is_read'], 'idx_notifications_recipient_read');
            $table->index('created_at', 'idx_notifications_created_at');
            $table->index(['type', 'reference_type', 'reference_id'], 'idx_notifications_type_ref');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('cohort_messages');
    }
};
