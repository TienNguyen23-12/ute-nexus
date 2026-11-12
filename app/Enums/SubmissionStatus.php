<?php

declare(strict_types=1);

namespace App\Enums;

enum SubmissionStatus: string
{
    case PENDING = 'PENDING';
    case SUBMITTED = 'SUBMITTED';
    case GRADED = 'GRADED';
    case PENDING_MANUAL_GRADE = 'PENDING_MANUAL_GRADE';
    case COMPLETED = 'COMPLETED';
}
