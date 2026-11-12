<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AuthProvider;
use App\Enums\RoleCode;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('Abc@1234');

        $sampleUsers = [
            [
                'username' => 'admin',
                'email' => 'admin@utenexus.edu.vn',
                'name' => 'Quản trị viên hệ thống',
                'phone_number' => '0901234567',
                'role' => RoleCode::ADMIN,
            ],
            [
                'username' => 'instructor',
                'email' => 'instructor@utenexus.edu.vn',
                'name' => 'Giảng viên Khoa CNTT',
                'phone_number' => '0902345678',
                'role' => RoleCode::INSTRUCTOR,
            ],
            [
                'username' => 'moderator',
                'email' => 'moderator@utenexus.edu.vn',
                'name' => 'Người kiểm duyệt nội dung',
                'phone_number' => '0903456789',
                'role' => RoleCode::MODERATOR,
            ],
            [
                'username' => 'finance',
                'email' => 'finance@utenexus.edu.vn',
                'name' => 'Kế toán viên UTENexus',
                'phone_number' => '0905678901',
                'role' => RoleCode::FINANCE,
            ],
            [
                'username' => 'student',
                'email' => 'student@utenexus.edu.vn',
                'name' => 'Học viên UTENexus',
                'phone_number' => '0904567890',
                'role' => RoleCode::STUDENT,
            ],
        ];

        foreach ($sampleUsers as $item) {
            $user = User::firstOrCreate(
                ['username' => $item['username']],
                [
                    'email' => $item['email'],
                    'name' => $item['name'],
                    'password' => $defaultPassword,
                    'phone_number' => $item['phone_number'],
                    'is_active' => true,
                    'auth_provider' => AuthProvider::LOCAL,
                    'balance' => '0.00',
                    'email_verified_at' => now(),
                ]
            );

            $role = Role::where('code', $item['role']->value)->first();
            if ($role !== null) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
        }
    }
}
