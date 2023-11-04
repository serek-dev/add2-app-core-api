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

final class OrmDayViewViewRepository implements FindDayViewInterface, FindDayStatsViewInterface
{
    public function __construct(private readonly EntityManagerInterface $viewsEntityManager)
    {
    }

    public function findDay(string $date): DayView
    {
        $repo = $this->viewsEntityManager->getRepository(DayView::class);
        return $repo->findOneBy(['date' => new DateTimeImmutable($date)]) ?? DayView::createEmpty($date);
    }

    /** @inheritDoc */
    public function findStats(DateTimeInterface $from, DateTimeInterface $to): array
    {
        $statement = $this->viewsEntityManager->getConnection()->prepare(file_get_contents(__DIR__ . '/findStats.sql'));
        $result = $statement->executeQuery([':from' => $from->format('Y-m-d'), ':to' => $to->format('Y-m-d')])->fetchAllAssociative();

        return array_map(fn(array $row) => DayStatsView::fromArray($row), $result);
    }
}
