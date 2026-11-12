<?php

declare(strict_types=1);

namespace App\Enums;

enum LessonStatus: string
{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
}
