<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ModerationItemType;
use App\Enums\ModerationTaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModerationTask extends Model
{
    protected $fillable = [
        'item_type',
        'item_id',
        'author_id',
        'cohort_id',
        'assigned_to',
        'status',
        'estimated_review_minutes',
        'assigned_at',
        'deadline_at',
        'escalation_level',
        'escalated_by',
        'escalation_reason',
        'feedback',
    ];

    protected $attributes = [
        'status' => ModerationTaskStatus::PENDING->value,
        'estimated_review_minutes' => 60,
        'escalation_level' => 1,
    ];

    protected function casts(): array
    {
        return [
            'item_type' => ModerationItemType::class,
            'item_id' => 'integer',
            'status' => ModerationTaskStatus::class,
            'estimated_review_minutes' => 'integer',
            'assigned_at' => 'datetime',
            'deadline_at' => 'datetime',
            'escalation_level' => 'integer',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function escalatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'escalated_by');
    }
}
