<?php

namespace App\Metric\Repository;

use App\Metric\Entity\Metric;
use App\Metric\Value\AggregationType;
use DateTimeImmutable;

interface FindMetricsInterface
{
    /**
     * @param string[] $types
     * @return Metric[]
     */
    public function findByTypesTimeAscOrdered(DateTimeImmutable $from, DateTimeImmutable $to, array $types = []): array;

    /**
     * @param string[] $types
     * @return Metric[]
     */
    public function findAggregatedByTypesTimeAscOrdered(AggregationType $aggregation, DateTimeImmutable $from, DateTimeImmutable $to, array $types = []): array;
}