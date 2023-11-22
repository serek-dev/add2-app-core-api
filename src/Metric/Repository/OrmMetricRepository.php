<?php

declare(strict_types=1);

namespace App\Metric\Repository;

use App\Metric\Entity\Metric;
use App\Metric\Value\AggregationType;
use App\Metric\Value\MetricType;
use DateTimeImmutable;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use function array_map;
use function file_get_contents;
use function implode;
use function str_replace;

final readonly class OrmMetricRepository implements CreateMetricInterface, FindMetricsInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function store(Metric ...$metric): void
    {
        foreach ($metric as $m) {
            $this->entityManager->persist($m);
        }
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

    private function adjustTime(DateTimeImmutable $time, bool $down): DateTimeImmutable
    {
        return $time->setTime(
            $down ? 0 : 23,
            $down ? 0 : 59,
            $down ? 0 : 59);
    }

    /**
     * @param string[] $types
     * @return Metric[]
     * @throws Exception
     */
    public function getResultsUsingSqlFromFile(DateTimeImmutable $from, DateTimeImmutable $to, array $types, string $fileName, ?AggregationType $aggregationType = null): array
    {
        $from = $this->adjustTime($from, true);
        $to = $this->adjustTime($to, false);

        $rawSql = file_get_contents(__DIR__ . '/' . $fileName);

        $rawSql = str_replace('--AGGREGATION--', $aggregationType?->value ?? '', $rawSql);

        $types = array_map(fn(string $t) => "'$t'", $types);
        $rawSql = str_replace('--TYPES--', implode(', ', $types), $rawSql);

        $statement = $this->entityManager->getConnection()->prepare($rawSql);

        $statement->bindValue('from', $from->format('Y-m-d H:i'));
        $statement->bindValue('to', $to->format('Y-m-d H:i'));

        $result = $statement->executeQuery()->fetchAllAssociative();

        return array_map(fn(array $row) => new Metric($row['type'], $row['value'], new DateTimeImmutable($row['time'])), $result);
    }

    public function removeByParentIdAndName(string $parentId, string $parentName): void
    {
        $metric = $this->entityManager->getRepository(Metric::class)->findOneBy([
            'parentId' => $parentId,
            'parentName' => $parentName,
        ]);

        if (!$metric) {
            return;
        }

        $this->entityManager->remove($metric);
        $this->entityManager->flush();
    }

    public function updateByParentIdAndType(string $parentId, MetricType $type, float $value): void
    {
        $metric = $this->entityManager->getRepository(Metric::class)->findOneBy([
            'parentId' => $parentId,
            'type' => $type->value,
        ]);

        if (!$metric) {
            return;
        }

        $metric->setValue($value);

        $this->entityManager->persist($metric);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function findAggregatedByTypesTimeAscOrdered(AggregationType $aggregation, DateTimeImmutable $from, DateTimeImmutable $to, array $types = []): array
    {
        return $this->getResultsUsingSqlFromFile($from, $to, $types, 'findAggregatedByTypesTimeAscOrdered.sql', $aggregation);
    }
}