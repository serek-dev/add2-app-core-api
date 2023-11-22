<?php

declare(strict_types=1);

namespace App\Metric\Value;

enum AggregationType: string
{
    case SUM = 'SUM';
    case AVG = 'AVG';
    case MAX = 'MAX';
}