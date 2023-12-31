<?php

declare(strict_types=1);

namespace App\ActivityLog\Repository;

use App\ActivityLog\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;

final readonly class OrmPersistenceRepository implements PersistenceInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function store(Activity $activity): void
    {
        $this->em->persist($activity);
        $this->em->flush();
    }
}