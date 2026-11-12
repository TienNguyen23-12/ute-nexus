<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\CourseStatus;
use App\Enums\RoleCode;
use App\Models\Course;
use App\Models\PayrollConfig;
use App\Models\Quiz;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_domain_tables_are_created(): void
    {
        $expectedTables = [
            'users',
            'roles',
            'permissions',
            'role_permissions',
            'user_roles',
            'registration_otps',
            'instructor_assets',
            'categories',
            'courses',
            'cohorts',
            'sections',
            'lessons',
            'cohort_members',
            'cohort_schedules',
            'enrollments',
            'lesson_completions',
            'lesson_notes',
            'quizzes',
            'questions',
            'quiz_submissions',
            'assignments',
            'assignment_submissions',
            'coding_problems',
            'coding_submissions',
            'moderator_attendances',
            'moderation_tasks',
            'payroll_configs',
            'discounts',
            'cart_items',
            'wishlists',
            'orders',
            'cohort_messages',
            'notifications',
        ];

        foreach ($expectedTables as $table) {
            $this->assertTrue(Schema::hasTable($table), "Missing table: {$table}");
        }
    }

    public function test_database_seeder_populates_initial_data_idempotently(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(6, Role::count());
        $this->assertSame(5, User::count());
        $this->assertSame(3, Course::count());
        $this->assertSame(1, PayrollConfig::where('is_global', true)->count());

        $admin = User::where('username', 'admin')->firstOrFail();
        $this->assertTrue($admin->roles()->where('code', RoleCode::ADMIN->value)->exists());
        $this->assertSame(6, $admin->roles->first()->permissions()->count());

        $course = Course::where('slug', 'java-spring-boot-doanh-nghiep')->firstOrFail();
        $this->assertSame(CourseStatus::PUBLISHED, $course->status);
        $this->assertSame(3, $course->cohorts()->count());

        $quiz = Quiz::firstOrFail();
        $this->assertSame(4, $quiz->questions()->count());
    }
}
