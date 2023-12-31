<?php
declare(strict_types=1);

namespace App\ActivityLog\Repository;

use App\ActivityLog\Entity\Activity;

interface PersistenceInterface
{
    public function store(Activity $activity): void;
}