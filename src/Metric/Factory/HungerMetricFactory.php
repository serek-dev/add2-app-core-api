<?php

declare(strict_types=1);

namespace App\Metric\Factory;

use App\Metric\Entity\Metric;
use DateTimeImmutable;
use DomainException;

final class HungerMetricFactory implements MetricFactoryInterface
{
    public function supports(string $type): bool
    {
        return $type === 'hunger';
    }

    public function create(string $type, float|int|string $value, DateTimeImmutable $date): Metric
    {
        if ($value < 1 || $value > 10) {
            throw new DomainException('Invalid hunger value');
        }

        return new Metric($type, (int)$value, $date);
    }
}