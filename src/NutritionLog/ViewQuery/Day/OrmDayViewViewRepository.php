<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;


use App\NutritionLog\View\DayView;
use Doctrine\ORM\EntityManagerInterface;

final class OrmDayViewViewRepository implements FindDayViewInterface
{
    public function __construct(private readonly EntityManagerInterface $viewsEntityManager)
    {
    }

    public function findDay(string $date): DayView
    {
        $repo = $this->viewsEntityManager->getRepository(DayView::class);
        return $repo->findOneBy(['date' => $date]) ?? DayView::createEmpty($date);
    }
}
