<?php

declare(strict_types=1);

use App\Enums\DiscountType;
use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 255);
            $table->string('discount_type', 20)->default(DiscountType::PERCENTAGE->value);
            $table->decimal('discount_value', 12, 2);
            $table->decimal('max_discount_amount', 12, 2)->nullable();
            $table->decimal('min_order_amount', 12, 2)->default(0);
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->timestampTz('start_date')->nullable();
            $table->timestampTz('end_date')->nullable();
            $table->boolean('active')->default(true);
            $table->string('created_by', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('cart_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('item_type', 20);
            $table->foreignId('course_id')->nullable()->constrained('courses')->cascadeOnDelete();
            $table->foreignId('cohort_id')->nullable()->constrained('cohorts')->cascadeOnDelete();
            $table->timestamps();

            $table->index('user_id', 'idx_cart_items_user');
        });

        DB::statement('CREATE UNIQUE INDEX uq_cart_user_course ON cart_items (user_id, course_id) WHERE course_id IS NOT NULL');
        DB::statement('CREATE UNIQUE INDEX uq_cart_user_cohort ON cart_items (user_id, cohort_id) WHERE cohort_id IS NOT NULL');

        Schema::create('wishlists', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'course_id'], 'uq_wishlist_user_course');
            $table->index('user_id', 'idx_wishlists_user');
        });

        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_code', 50)->unique();
            $table->decimal('total_amount', 12, 2);
            $table->string('discount_code', 50)->nullable();
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->string('status', 30)->default(OrderStatus::PENDING->value);
            $table->string('payment_method', 50)->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->jsonb('items')->default('[]');
            $table->timestampTz('paid_at')->nullable();
            $table->string('confirmed_by', 100)->nullable();
            $table->string('payment_note', 500)->nullable();
            $table->timestampTz('expires_at')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_orders_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('wishlists');
        DB::statement('DROP INDEX IF EXISTS uq_cart_user_cohort');
        DB::statement('DROP INDEX IF EXISTS uq_cart_user_course');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('discounts');
    }
};
