<?php

declare(strict_types=1);


namespace App\Product\Persistence\Meal;


use App\Product\Entity\Meal;
use Doctrine\ORM\EntityManagerInterface;

final class OrmMealRepository implements StoreMealInterface, FindMealByNameInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function store(Meal $meal): void
    {
        $this->em->persist($meal);
        $this->em->flush();
    }

    public function findByName(string $name): ?Meal
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('m')
            ->from(Meal::class, 'm');

        $qb->where('m.name = :name');
        $qb->setParameter('name', $name);

        $qb->setMaxResults(1);

        return $qb->getQuery()->getResult()[0] ?? null;
    }
}
