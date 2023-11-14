<?php

declare(strict_types=1);

namespace App\Metric\Repository;

use App\Metric\Entity\Metric;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use function array_map;
use function file_get_contents;
use function implode;

final class OrmMetricRepository implements CreateMetricInterface, FindMetricsInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function store(Metric $metric): void
    {
        $this->entityManager->persist($metric);
        $this->entityManager->flush();
    }

    /** @inheritDoc */
    public function findByTypesTimeAscOrdered(DateTimeImmutable $from, DateTimeImmutable $to, array $types = []): array
    {
        $from = $this->adjustTime($from, true);
        $to = $this->adjustTime($to, false);

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('metric')
            ->from(Metric::class, 'metric')
            ->where($qb->expr()->between('metric.time', ':from', ':to'));

        if (!empty($types)) {
            $qb->andWhere($qb->expr()->in('metric.type', ':types'));
            $qb->setParameter('types', $types);
        }

        $qb
            ->orderBy('metric.time', 'ASC')
            ->setParameter('from', $from)
            ->setParameter('to', $to);

        return $qb->getQuery()->getResult();
    }

    public function findAverageByTypesTimeAscOrdered(DateTimeImmutable $from, DateTimeImmutable $to, array $types = []): array
    {
        $from = $this->adjustTime($from, true);
        $to = $this->adjustTime($to, false);

        $rawSql = file_get_contents(__DIR__ . '/findAverageByTypesTimeAscOrdered.sql');
        $statement = $this->entityManager->getConnection()->prepare($rawSql);

        $statement->bindValue('from', $from->format('Y-m-d H:i'));
        $statement->bindValue('to', $to->format('Y-m-d H:i'));
        $statement->bindValue('types', implode(',', $types));

        $result = $statement->executeQuery()->fetchAllAssociative();

        return array_map(fn(array $row) => new Metric($row['type'], $row['value'], new DateTimeImmutable($row['time'])), $result);
    }

    private function adjustTime(DateTimeImmutable $time, bool $down): DateTimeImmutable
    {
        return $time->setTime(
            $down ? 0 : 23,
            $down ? 0 : 59,
            $down ? 0 : 59);
    }
}