<?php

declare(strict_types=1);

namespace App\Metric\Repository;

use App\Metric\Dto\CreateMetricDtoInterface;
use App\Metric\Entity\Metric;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final class OrmMetricRepository implements CreateMetricInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function store(Metric $metric): void
    {
        $this->entityManager->persist($metric);
        $this->entityManager->flush();
    }
}