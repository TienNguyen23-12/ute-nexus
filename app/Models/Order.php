<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_code',
        'total_amount',
        'discount_code',
        'discount_amount',
        'status',
        'payment_method',
        'transaction_id',
        'items',
        'paid_at',
        'confirmed_by',
        'payment_note',
        'expires_at',
    ];

    protected $attributes = [
        'discount_amount' => '0.00',
        'status' => OrderStatus::PENDING->value,
        'items' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'status' => OrderStatus::class,
            'payment_method' => PaymentMethod::class,
            'items' => 'array',
            'paid_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
