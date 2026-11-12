<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PermissionModule;
use App\Enums\RoleCode;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = $this->seedRoles();
        $permissions = $this->seedPermissions();
        $this->assignRolePermissions($roles, $permissions);
    }

    private function seedRoles(): array
    {
        $definitions = [
            [
                'code' => RoleCode::ADMIN,
                'name' => 'Quản trị viên toàn hệ thống',
                'description' => 'Toàn quyền cấu hình và quản trị nền tảng UTENexus',
            ],
            [
                'code' => RoleCode::MODERATOR,
                'name' => 'Người kiểm duyệt nội dung',
                'description' => 'Nhận nhiệm vụ từ hàng đợi để duyệt bài giảng, đề thi và OJ',
            ],
            [
                'code' => RoleCode::INSTRUCTOR,
                'name' => 'Giảng viên',
                'description' => 'Soạn giáo trình, quản lý kho tài nguyên số, mở lớp theo đợt và chấm bài',
            ],
            [
                'code' => RoleCode::TA,
                'name' => 'Trợ giảng',
                'description' => 'Hỗ trợ giải đáp lớp học thời gian thực và trợ giảng',
            ],
            [
                'code' => RoleCode::STUDENT,
                'name' => 'Học viên',
                'description' => 'Đăng ký lớp học theo đợt, làm bài tập và luyện code Online Judge',
            ],
            [
                'code' => RoleCode::FINANCE,
                'name' => 'Kế toán / Quản lý thanh toán',
                'description' => 'Theo dõi dòng tiền, đối soát giao dịch và duyệt thanh toán đơn hàng',
            ],
        ];

        $map = [];
        foreach ($definitions as $item) {
            $role = Role::updateOrCreate(
                ['code' => $item['code']->value],
                ['name' => $item['name'], 'description' => $item['description']]
            );
            $map[$item['code']->value] = $role;
        }

        return $map;
    }

    private function seedPermissions(): array
    {
        $definitions = [
            ['code' => 'USER_MANAGE', 'name' => 'Quản lý tài khoản người dùng', 'module' => PermissionModule::AUTH],
            ['code' => 'ROLE_MANAGE', 'name' => 'Cấu hình phân quyền động', 'module' => PermissionModule::AUTH],
            ['code' => 'COURSE_CREATE', 'name' => 'Tạo và chỉnh sửa khóa học chuẩn', 'module' => PermissionModule::COURSE],
            ['code' => 'CONTENT_APPROVE', 'name' => 'Phê duyệt nội dung bài giảng và đề thi', 'module' => PermissionModule::MODERATION],
            ['code' => 'ASSET_MANAGE', 'name' => 'Quản lý kho tài nguyên số cá nhân', 'module' => PermissionModule::ASSET],
            ['code' => 'ORDER_MANAGE', 'name' => 'Quản lý và đối soát đơn hàng', 'module' => PermissionModule::PAYMENT],
        ];

        $map = [];
        foreach ($definitions as $item) {
            $permission = Permission::updateOrCreate(
                ['code' => $item['code']],
                ['name' => $item['name'], 'module' => $item['module']->value]
            );
            $map[$item['code']] = $permission;
        }

        return $map;
    }

    private function assignRolePermissions(array $roles, array $permissions): void
    {
        $allPermissionIds = array_map(fn (Permission $p): int => $p->id, $permissions);

        $roles[RoleCode::ADMIN->value]->permissions()->syncWithoutDetaching($allPermissionIds);
        $roles[RoleCode::FINANCE->value]->permissions()->syncWithoutDetaching([$permissions['ORDER_MANAGE']->id]);
        $roles[RoleCode::MODERATOR->value]->permissions()->syncWithoutDetaching([$permissions['CONTENT_APPROVE']->id]);
        $roles[RoleCode::INSTRUCTOR->value]->permissions()->syncWithoutDetaching([
            $permissions['COURSE_CREATE']->id,
            $permissions['ASSET_MANAGE']->id,
        ]);
    }
}
