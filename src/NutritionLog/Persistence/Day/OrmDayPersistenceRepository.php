<?php

declare(strict_types=1);


namespace App\NutritionLog\Persistence\Day;


use App\NutritionLog\Entity\Day;
use App\NutritionLog\Value\ConsumptionTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;

final class OrmDayPersistenceRepository implements FindDayByDateInterface, DayPersistenceInterface, RemoveInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function findDayByDate(DateTimeInterface $date): ?Day
    {
        return $this->em->getRepository(Day::class)->findOneBy([
            'date' => $date->format('Y-m-d')
        ]);
    }

    public function store(Day $day): void
    {
        $this->em->persist($day);
        $this->em->flush();
    }

    public function removeProductsAndMeals(Day $day, ConsumptionTime $time): void
    {
        // todo: wtf, this default removal does not work
        foreach ($day->removeProductsAndMeals($time) as $item) {
            $this->em->remove($item);
        }
        $this->em->flush();
    }
}