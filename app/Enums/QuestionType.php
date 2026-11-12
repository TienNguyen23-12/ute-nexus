<?php

declare(strict_types=1);

namespace App\Enums;

enum QuestionType: string
{
    case SINGLE_CHOICE = 'SINGLE_CHOICE';
    case MULTI_SELECT = 'MULTI_SELECT';
    case TRUE_FALSE = 'TRUE_FALSE';
    case FILL_BLANK = 'FILL_BLANK';
    case ESSAY = 'ESSAY';
}
