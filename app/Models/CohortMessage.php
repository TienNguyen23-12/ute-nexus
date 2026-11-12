<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CohortMessageType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CohortMessage extends Model
{
    protected $fillable = [
        'cohort_id',
        'sender_id',
        'message',
        'message_type',
        'is_deleted_for_all',
        'deleted_by_user_id',
        'hidden_for_user_ids',
    ];

    protected $attributes = [
        'message_type' => CohortMessageType::TEXT->value,
        'is_deleted_for_all' => false,
    ];

    protected function casts(): array
    {
        return [
            'message_type' => CohortMessageType::class,
            'is_deleted_for_all' => 'boolean',
            'deleted_by_user_id' => 'integer',
        ];
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class, 'cohort_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
