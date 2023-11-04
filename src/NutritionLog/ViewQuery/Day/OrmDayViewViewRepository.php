<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;


use App\NutritionLog\View\DayStatsView;
use App\NutritionLog\View\DayView;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use function array_map;

final class OrmDayViewViewRepository implements FindDayViewInterface, FindDayStatsViewInterface
{
    public function __construct(private readonly EntityManagerInterface $viewsEntityManager)
    {
    }

    public function findDay(string $date): DayView
    {
        $repo = $this->viewsEntityManager->getRepository(DayView::class);
        return $repo->findOneBy(['date' => $date]) ?? DayView::createEmpty($date);
    }

    /** @inheritDoc */
    public function findStats(DateTimeInterface $from, DateTimeInterface $to): array
    {
        $query = $this->viewsEntityManager->createQueryBuilder()
            ->select('day.date, (SUM(dmp.kcal)) AS kcal, (SUM(dmp.proteins)) AS proteins, (SUM(dmp.fats)) AS fats, (SUM(dmp.carbs)) AS carbs')
            ->from(DayView::class, 'day')
            ->leftJoin('day.meals', 'dm')
            ->leftJoin('dm.products', 'dmp')
            ->where('day.date >= :startDate')
            ->andWhere('day.date <= :endDate')
            ->setParameter('startDate', $from)
            ->setParameter('endDate', $to)
            ->groupBy('day.date')
            ->orderBy('day.date', 'ASC')
            ->getQuery();

        return array_map(fn(array $row) => DayStatsView::fromArray($row), $query->getArrayResult());
    }
}
