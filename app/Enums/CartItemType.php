<?php

declare(strict_types=1);

namespace App\Enums;

enum CartItemType: string
{
    case COURSE = 'COURSE';
    case COHORT = 'COHORT';
}
