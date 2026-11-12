<?php

declare(strict_types=1);

namespace App\Enums;

enum CohortStatus: string
{
    case UPCOMING = 'UPCOMING';
    case ENROLLING = 'ENROLLING';
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMPLETED';
}
