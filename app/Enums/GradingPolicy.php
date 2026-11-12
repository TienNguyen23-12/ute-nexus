<?php

declare(strict_types=1);

namespace App\Enums;

enum GradingPolicy: string
{
    case PROGRESS_BASED = 'PROGRESS_BASED';
    case WEIGHTED = 'WEIGHTED';
    case FINAL_EXAM = 'FINAL_EXAM';
}
