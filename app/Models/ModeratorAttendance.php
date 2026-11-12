<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModeratorAttendance extends Model
{
    protected $fillable = [
        'moderator_id',
        'work_date',
        'is_active',
        'max_daily_minutes',
        'assigned_tasks_count',
        'completed_tasks_count',
        'active_tasks_count',
        'total_workload_minutes',
        'check_in_at',
        'check_out_at',
        'is_overtime',
        'ot_check_in_at',
        'ot_check_out_at',
        'ot_workload_minutes',
    ];

    protected $attributes = [
        'is_active' => true,
        'max_daily_minutes' => 480,
        'assigned_tasks_count' => 0,
        'completed_tasks_count' => 0,
        'active_tasks_count' => 0,
        'total_workload_minutes' => 0,
        'is_overtime' => false,
        'ot_workload_minutes' => 0,
    ];

    protected function casts(): array
    {
        return [
            'work_date' => 'date',
            'is_active' => 'boolean',
            'max_daily_minutes' => 'integer',
            'assigned_tasks_count' => 'integer',
            'completed_tasks_count' => 'integer',
            'active_tasks_count' => 'integer',
            'total_workload_minutes' => 'integer',
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
            'is_overtime' => 'boolean',
            'ot_check_in_at' => 'datetime',
            'ot_check_out_at' => 'datetime',
            'ot_workload_minutes' => 'integer',
        ];
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }
}
