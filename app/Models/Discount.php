<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'code',
        'name',
        'discount_type',
        'discount_value',
        'max_discount_amount',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'active',
        'created_by',
    ];

    protected $attributes = [
        'discount_type' => DiscountType::PERCENTAGE->value,
        'min_order_amount' => '0.00',
        'used_count' => 0,
        'active' => true,
    ];

    protected function casts(): array
    {
        return [
            'discount_type' => DiscountType::class,
            'discount_value' => 'decimal:2',
            'max_discount_amount' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'active' => 'boolean',
        ];
    }
}
