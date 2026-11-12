<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollConfig extends Model
{
    protected $fillable = [
        'user_id',
        'is_global',
        'instructor_share_percent',
        'instructor_rating_bonus_percent',
        'instructor_rating_threshold',
        'moderator_minute_rate',
        'moderator_ot_multiplier',
        'moderator_task_bonus',
        'moderator_sla_penalty',
        'fixed_allowance',
        'note',
    ];

    protected $attributes = [
        'is_global' => false,
        'fixed_allowance' => '0.00',
    ];

    protected function casts(): array
    {
        return [
            'is_global' => 'boolean',
            'instructor_share_percent' => 'decimal:2',
            'instructor_rating_bonus_percent' => 'decimal:2',
            'instructor_rating_threshold' => 'decimal:2',
            'moderator_minute_rate' => 'decimal:2',
            'moderator_ot_multiplier' => 'decimal:2',
            'moderator_task_bonus' => 'decimal:2',
            'moderator_sla_penalty' => 'decimal:2',
            'fixed_allowance' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
