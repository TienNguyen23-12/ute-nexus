<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionModule: string
{
    case AUTH = 'AUTH';
    case COURSE = 'COURSE';
    case MODERATION = 'MODERATION';
    case ASSET = 'ASSET';
    case PAYMENT = 'PAYMENT';
    case OJ = 'OJ';
}
