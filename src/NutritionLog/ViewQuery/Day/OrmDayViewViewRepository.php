<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;


use App\NutritionLog\View\DayStatsView;
use App\NutritionLog\View\DayView;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use function array_map;
use function file_get_contents;

final class OrmDayViewViewRepository implements FindDayViewInterface
{
    public function __construct(private readonly EntityManagerInterface $viewsEntityManager)
    {
    }

    public function findDay(string $date): DayView
    {
        $repo = $this->viewsEntityManager->getRepository(DayView::class);
        return $repo->findOneBy(['date' => new DateTimeImmutable($date)]) ?? DayView::createEmpty($date);
    }
}
