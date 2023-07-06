<?php

declare(strict_types=1);


namespace App\Diary\Factory;


use App\Diary\Entity\Day;
use App\Diary\Exception\DuplicateException;
use App\Diary\Persistence\Day\FindDayByDateInterface;
use DateTimeInterface;

final class DayFactory
{
    public function __construct(private readonly FindDayByDateInterface $findDayByDate)
    {
    }

    public function create(DateTimeInterface $dateTime): Day
    {
        if ($this->findDayByDate->findDayByDate($dateTime)) {
            throw new DuplicateException('Day already exists');
        }

        return new Day($dateTime);
    }
}
