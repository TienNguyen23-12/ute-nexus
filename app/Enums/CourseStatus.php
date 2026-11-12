<?php

declare(strict_types=1);

namespace App\Enums;

enum CourseStatus: string
{
    case DRAFT = 'DRAFT';
    case PENDING_REVIEW = 'PENDING_REVIEW';
    case PENDING_MODERATOR = 'PENDING_MODERATOR';
    case PENDING_ADMIN = 'PENDING_ADMIN';
    case APPROVED = 'APPROVED';
    case PUBLISHED = 'PUBLISHED';
    case REJECTED = 'REJECTED';
}
