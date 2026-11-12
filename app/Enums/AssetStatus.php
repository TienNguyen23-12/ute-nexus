<?php

declare(strict_types=1);

namespace App\Enums;

enum AssetStatus: string
{
    case PENDING_MODERATOR = 'PENDING_MODERATOR';
    case PENDING_ADMIN = 'PENDING_ADMIN';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
}
