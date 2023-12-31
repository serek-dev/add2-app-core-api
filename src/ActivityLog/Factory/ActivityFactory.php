<?php

declare(strict_types=1);

namespace App\ActivityLog\Factory;

use App\ActivityLog\Dto\ActivityDtoInterface;
use App\ActivityLog\Entity\Activity;
use DateTimeImmutable;
use function uniqid;

final class ActivityFactory
{
    public function create(ActivityDtoInterface $dto): Activity
    {
        return new Activity(
            id: uniqid('AL-'),
            type: $dto->getType(),
            name: $dto->getName(),
            date: $dto->getDate() ?? new DateTimeImmutable(),
            userId: $dto->getUserId(),
            duration: $dto->getDuration(),
            distance: $dto->getDistance(),
            elevation: $dto->getElevation() ?? 0,
            avgHr: $dto->getAvgHr() ?? 0,
            kcal: $dto->getKcal(),
        );
    }
}