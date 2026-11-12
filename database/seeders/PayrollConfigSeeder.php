<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PayrollConfig;
use Illuminate\Database\Seeder;

class PayrollConfigSeeder extends Seeder
{
    public function run(): void
    {
        PayrollConfig::firstOrCreate(
            ['is_global' => true, 'user_id' => null],
            [
                'instructor_share_percent' => '70.00',
                'instructor_rating_bonus_percent' => '5.00',
                'instructor_rating_threshold' => '4.50',
                'moderator_minute_rate' => '500.00',
                'moderator_ot_multiplier' => '1.50',
                'moderator_task_bonus' => '10000.00',
                'moderator_sla_penalty' => '15000.00',
                'fixed_allowance' => '0.00',
                'note' => 'Cấu hình mặc định toàn hệ thống',
            ]
        );
    }
}
