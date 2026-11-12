<?php

declare(strict_types=1);

namespace App\Enums;

enum NotificationCategory: string
{
    case ACADEMIC = 'ACADEMIC';
    case COHORT = 'COHORT';
    case TRANSACTION = 'TRANSACTION';
    case SYSTEM = 'SYSTEM';
}
