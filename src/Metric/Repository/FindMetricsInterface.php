<?php

namespace App\Metric\Repository;

use App\Metric\Entity\Metric;
use DateTimeInterface;

interface FindMetricsInterface
{
    /**
     * @param string[] $types
     * @return Metric[]
     */
    public function findByTypesTimeAscOrdered(DateTimeInterface $from, DateTimeInterface $to, array $types = []): array;

    /**
     * @param string[] $types
     * @return Metric[]
     */
    public function findAverageByTypesTimeAscOrdered(DateTimeInterface $from, DateTimeInterface $to, array $types = []): array;
}