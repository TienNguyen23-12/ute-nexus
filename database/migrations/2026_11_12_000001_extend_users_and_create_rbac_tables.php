<?php

declare(strict_types=1);

use App\Enums\AuthProvider;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('username', 100)->nullable()->unique()->after('id');
            $table->string('phone_number', 20)->nullable()->after('email');
            $table->text('avatar_url')->nullable()->after('phone_number');
            $table->boolean('is_active')->default(true)->after('avatar_url');
            $table->string('auth_provider', 50)->default(AuthProvider::LOCAL->value)->after('is_active');
            $table->decimal('balance', 15, 2)->default(0)->after('auth_provider');
        });

        Schema::create('roles', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 100)->unique();
            $table->string('name', 150);
            $table->string('module', 50);
            $table->timestamps();
        });

        Schema::create('role_permissions', function (Blueprint $table): void {
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->timestampTz('assigned_at')->useCurrent();
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('user_roles', function (Blueprint $table): void {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->timestampTz('assigned_at')->useCurrent();
            $table->primary(['user_id', 'role_id']);
        });

        Schema::create('registration_otps', function (Blueprint $table): void {
            $table->id();
            $table->string('email', 150)->index();
            $table->string('otp', 10);
            $table->timestampTz('expiry_date');
            $table->integer('attempt_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_otps');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');

        Schema::table('users', function (Blueprint $table): void {
            $table->dropUnique(['username']);
            $table->dropColumn([
                'username',
                'phone_number',
                'avatar_url',
                'is_active',
                'auth_provider',
                'balance',
            ]);
        });
    }
};
