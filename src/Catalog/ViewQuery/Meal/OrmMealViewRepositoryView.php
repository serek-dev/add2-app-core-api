<?php

declare(strict_types=1);


namespace App\Catalog\ViewQuery\Meal;


use App\Catalog\Exception\NotFoundException;
use App\Catalog\View\MealView;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

final class OrmMealViewRepositoryView implements FindMealViewsInterface, GetOneMealViewInterface
{
    public function __construct(private readonly EntityManagerInterface $viewsEntityManager)
    {
    }

    /** @inheritDoc */
    public function findAll(?string $userId = null, ?string $name = null): array
    {
        $qb = $this->viewsEntityManager->getRepository(MealView::class)->createQueryBuilder('m');

        $qb->where('m.userId = :userId');
        $qb->setParameter('userId', $userId);

        if ($name) {
            $qb->andWhere(
                $qb->expr()->like('m.name', $qb->expr()->literal('%' . $name . '%'))
            );
        }

        $qb->leftJoin('m.products', 'p');

        $qb->orderBy('m.name', 'asc');

        return $qb->getQuery()->getResult();
    }

    public function getOne(string $id): MealView
    {
        $qb = $this->viewsEntityManager->getRepository(MealView::class)->createQueryBuilder('m');

        try {
            $qb->where('m.id = :id')
                ->setParameter('id', $id)
                ->setMaxResults(1);

            /** @var MealView $res */
            $row =
                $qb
                    ->getQuery()
                    ->getSingleResult();
        } catch (NoResultException $e) {
            throw new NotFoundException();
        }

        return $row;
    }
}
