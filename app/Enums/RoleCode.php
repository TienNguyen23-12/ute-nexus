<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleCode: string
{
    case ADMIN = 'ADMIN';
    case MODERATOR = 'MODERATOR';
    case INSTRUCTOR = 'INSTRUCTOR';
    case TA = 'TA';
    case STUDENT = 'STUDENT';
    case FINANCE = 'FINANCE';
}
