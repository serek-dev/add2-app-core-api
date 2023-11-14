<?php

declare(strict_types=1);

namespace App\Metric\Factory;

use App\Metric\Entity\Metric;
use DateTimeInterface;
use DomainException;

final class WeightMetricFactory implements MetricFactoryInterface
{
    public function supports(string $type): bool
    {
        return $type === 'weight';
    }

    public function create(string $type, float|int|string $value, DateTimeInterface $date): Metric
    {
        if ($value <= 5 || $value >= 250) {
            throw new DomainException('Invalid weight value');
        }

        return new Metric($type, (float)$value, $date);
    }
}