<?php

declare(strict_types=1);

namespace App\Enums;

enum AssetType: string
{
    case VIDEO = 'VIDEO';
    case DOCUMENT = 'DOCUMENT';
    case SLIDE = 'SLIDE';
    case CODE_TEMPLATE = 'CODE_TEMPLATE';
    case TESTCASE = 'TESTCASE';
}
