<?php

declare(strict_types=1);

namespace App\NutritionLog\ViewQuery\Day;

use App\NutritionLog\View\DayStatsView;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use function array_map;
use function file_get_contents;

final readonly class DbalStatisticsRepository implements FindDayStatsViewInterface
{
    public function __construct(private EntityManagerInterface $viewsEntityManager)
    {
    }
    /** @inheritDoc */
    public function findStats(DateTimeInterface $from, DateTimeInterface $to, string $userId): array
    {
        $statement = $this->viewsEntityManager->getConnection()->prepare(
            file_get_contents(__DIR__ . '/findStats.sql')
        );
        $result = $statement->executeQuery([
                ':from' => $from->format('Y-m-d'),
                ':to' => $to->format('Y-m-d'),
                ':userId' => $userId,
            ]
        )->fetchAllAssociative();

        return array_map(fn(array $row) => DayStatsView::fromArray($row), $result);
    }
}