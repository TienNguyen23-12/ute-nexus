<?php

declare(strict_types=1);

namespace App\Enums;

enum CohortModerationStatus: string
{
    case DRAFT = 'DRAFT';
    case PENDING_MODERATOR = 'PENDING_MODERATOR';
    case PENDING_ADMIN = 'PENDING_ADMIN';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
}
