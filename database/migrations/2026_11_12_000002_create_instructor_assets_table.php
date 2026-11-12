<?php

declare(strict_types=1);

use App\Enums\AssetStatus;
use App\Enums\Visibility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructor_assets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('asset_type', 50);
            $table->text('cloudinary_url');
            $table->bigInteger('file_size_bytes')->default(0);
            $table->string('folder_path', 255)->default('/');
            $table->string('visibility', 30)->default(Visibility::PRIVATE->value);
            $table->text('shared_emails')->nullable();
            $table->string('status', 30)->default(AssetStatus::PENDING_MODERATOR->value);
            $table->timestamps();

            $table->index('instructor_id', 'idx_assets_instructor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructor_assets');
    }
};
