<?php

declare(strict_types=1);

namespace App\Enums;

enum CodingSubmissionStatus: string
{
    case PENDING = 'PENDING';
    case ACCEPTED = 'ACCEPTED';
    case WRONG_ANSWER = 'WRONG_ANSWER';
    case TIME_LIMIT_EXCEEDED = 'TIME_LIMIT_EXCEEDED';
    case MEMORY_LIMIT_EXCEEDED = 'MEMORY_LIMIT_EXCEEDED';
    case RUNTIME_ERROR = 'RUNTIME_ERROR';
    case COMPILE_ERROR = 'COMPILE_ERROR';
}
