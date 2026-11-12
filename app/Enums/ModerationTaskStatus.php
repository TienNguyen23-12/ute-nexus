<?php

declare(strict_types=1);

namespace App\Enums;

enum ModerationTaskStatus: string
{
    case PENDING = 'PENDING';
    case ASSIGNED = 'ASSIGNED';
    case IN_REVIEW = 'IN_REVIEW';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case ESCALATED = 'ESCALATED';
    case RE_QUEUED = 'RE_QUEUED';
}
