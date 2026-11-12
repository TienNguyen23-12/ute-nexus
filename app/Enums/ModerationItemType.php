<?php

declare(strict_types=1);

namespace App\Enums;

enum ModerationItemType: string
{
    case COURSE = 'COURSE';
    case COHORT = 'COHORT';
    case ASSET = 'ASSET';
    case LESSON = 'LESSON';
    case QUIZ = 'QUIZ';
    case CODING_PROBLEM = 'CODING_PROBLEM';
}
