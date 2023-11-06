<?php

declare(strict_types=1);

namespace App\Metric\Repository;

use App\Metric\Dto\CreateMetricDtoInterface;
use App\Metric\Entity\Metric;
use DateTimeInterface;
use Exception;

interface CreateMetricInterface
{
    public function store(Metric $metric): void;
}