<?php

declare(strict_types=1);


namespace App\Diary\Persistence\Day;

use App\Diary\Entity\Day;
use DateTimeInterface;

interface FindDayByDateInterface
{
    public function findDayByDate(DateTimeInterface $date): ?Day;
}
