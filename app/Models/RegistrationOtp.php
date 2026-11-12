<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationOtp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expiry_date',
        'attempt_count',
    ];

    protected $attributes = [
        'attempt_count' => 0,
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'datetime',
            'attempt_count' => 'integer',
        ];
    }

    public function isExpired(): bool
    {
        return now()->isAfter($this->expiry_date);
    }
}
