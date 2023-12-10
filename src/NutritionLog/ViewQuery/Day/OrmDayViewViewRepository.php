<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;


use App\NutritionLog\View\DayView;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final readonly class OrmDayViewViewRepository implements FindDayViewInterface
{
    public function __construct(private EntityManagerInterface $viewsEntityManager)
    {
    }

    public function findByDateAndUser(string $date, string $userId): DayView
    {
        $repo = $this->viewsEntityManager->getRepository(DayView::class);
        return $repo->findOneBy([
            'date' => new DateTimeImmutable($date),
            'userId' => $userId,
        ]) ?? DayView::createEmpty($date);
    }
}
