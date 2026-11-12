<?php

declare(strict_types=1);

namespace App\Enums;

enum CohortRole: string
{
    case STUDENT = 'STUDENT';
    case TA = 'TA';
    case INSTRUCTOR = 'INSTRUCTOR';
}
