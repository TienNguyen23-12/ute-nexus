<?php

declare(strict_types=1);

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('headline', 500)->nullable();
            $table->text('description')->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->string('level', 30)->default(CourseLevel::ALL_LEVELS->value);
            $table->string('status', 30)->default(CourseStatus::DRAFT->value);
            $table->decimal('price', 12, 2)->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->jsonb('objectives')->default('[]');
            $table->jsonb('requirements')->default('[]');
            $table->timestamps();

            $table->index('category_id', 'idx_courses_category');
            $table->index('created_by', 'idx_courses_creator');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
        Schema::dropIfExists('categories');
    }
};
