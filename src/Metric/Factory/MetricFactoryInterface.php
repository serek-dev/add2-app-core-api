<?php

declare(strict_types=1);

namespace App\Metric\Factory;

use App\Metric\Entity\Metric;
use DateTimeInterface;

interface MetricFactoryInterface
{
    public function supports(string $type): bool;

    public function create(string $type, float|string|int $value, DateTimeInterface $date, ?string $parentId, ?string $parentName): Metric;
}