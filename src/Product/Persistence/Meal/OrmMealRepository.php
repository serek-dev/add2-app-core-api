<?php

declare(strict_types=1);


namespace App\Product\Persistence\Meal;


use App\Product\Entity\Meal;
use Doctrine\ORM\EntityManagerInterface;

final class OrmMealRepository implements StoreMealInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function store(Meal $meal): void
    {
        $this->em->persist($meal);
        $this->em->flush();
    }
}
