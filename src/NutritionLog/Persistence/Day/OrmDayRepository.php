<?php

declare(strict_types=1);


namespace App\NutritionLog\Persistence\Day;


use App\NutritionLog\Entity\Day;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;

final class OrmDayRepository implements FindDayByDateInterface, StoreDayInterface
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
}
