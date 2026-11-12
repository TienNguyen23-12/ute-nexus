<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentMethod: string
{
    case OFFLINE_COUNTER = 'OFFLINE_COUNTER';
    case OFFLINE_CASH = 'OFFLINE_CASH';
    case OFFLINE_BANK_TRANSFER = 'OFFLINE_BANK_TRANSFER';
    case VIETQR_SEPAY = 'VIETQR_SEPAY';
    case VIETQR = 'VIETQR';
    case WALLET = 'WALLET';
    case FREE = 'FREE';
    case DEMO_SIMULATION = 'DEMO_SIMULATION';
    case VIETQR_TEST = 'VIETQR_TEST';
    case MANUAL_ADMIN = 'MANUAL_ADMIN';
}
