<?php

declare(strict_types=1);

namespace App\Enums;

enum CourseLevel: string
{
    case ALL_LEVELS = 'ALL_LEVELS';
    case BEGINNER = 'BEGINNER';
    case INTERMEDIATE = 'INTERMEDIATE';
    case ADVANCED = 'ADVANCED';
}
