<?php

declare(strict_types=1);

namespace App\NutritionLog\Repository;

use App\NutritionLog\Entity\Day;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DayRepository implements FindClosestPreviousDayInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function findClosest(DateTimeInterface $dateTime): ?Day
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('day');
        $queryBuilder->from(Day::class, 'day');

        $queryBuilder->where('day.date <= :now AND day.date != :now')
            ->setParameter('now', $dateTime);

        $queryBuilder->andWhere('day.date >= :sub')
            ->setParameter('sub', $dateTime->modify('-1 week'));

        $queryBuilder->orderBy('day.date', 'DESC');

        return $queryBuilder->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }
}