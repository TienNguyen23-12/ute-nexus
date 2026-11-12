<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\NotificationCategory;
use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'recipient_id',
        'sender_id',
        'title',
        'content',
        'type',
        'category',
        'action_url',
        'reference_id',
        'reference_type',
        'is_read',
        'read_at',
    ];

    protected $attributes = [
        'category' => NotificationCategory::ACADEMIC->value,
        'is_read' => false,
    ];

    protected function casts(): array
    {
        return [
            'type' => NotificationType::class,
            'category' => NotificationCategory::class,
            'reference_id' => 'integer',
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
