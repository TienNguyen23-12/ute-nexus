<?php

declare(strict_types=1);

namespace App\Enums;

enum CohortMessageType: string
{
    case TEXT = 'TEXT';
    case SYSTEM = 'SYSTEM';
    case IMAGE = 'IMAGE';
    case FILE = 'FILE';
}
