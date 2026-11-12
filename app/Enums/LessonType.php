<?php

declare(strict_types=1);

namespace App\Enums;

enum LessonType: string
{
    case VIDEO = 'VIDEO';
    case DOCUMENT = 'DOCUMENT';
    case QUIZ = 'QUIZ';
    case CODE_PRACTICE = 'CODE_PRACTICE';
    case ANNOUNCEMENT = 'ANNOUNCEMENT';
    case ASSIGNMENT = 'ASSIGNMENT';
}
