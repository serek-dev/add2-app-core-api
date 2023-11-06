<?php

declare(strict_types=1);

namespace App\Metric\Factory;

use App\Metric\Entity\Metric;
use DateTimeImmutable;

interface MetricFactoryInterface
{
    public function supports(string $type): bool;

    public function create(string $type, float|string|int $value, DateTimeImmutable $date): Metric;
}