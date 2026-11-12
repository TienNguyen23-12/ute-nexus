<?php

declare(strict_types=1);

namespace App\Enums;

enum ShowScoreType: string
{
    case IMMEDIATELY = 'IMMEDIATELY';
    case AFTER_DEADLINE = 'AFTER_DEADLINE';
    case MANUAL = 'MANUAL';
}
