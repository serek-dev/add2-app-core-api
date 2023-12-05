<?php

declare(strict_types=1);


namespace App\Catalog\ViewQuery\Product;


use App\Catalog\Exception\NotFoundException;
use App\Catalog\View\ProductView;
use Doctrine\ORM\EntityManagerInterface;

final class OrmProductViewRepository implements FindProductViewsInterface
{

    public function __construct(private readonly EntityManagerInterface $viewsEntityManager)
    {
    }

    /** @inheritDoc */
    public function findAllByUserAndName(string $userId, ?string $name = null): array
    {
        $qb = $this->viewsEntityManager->createQueryBuilder();

        $qb->select('p')
            ->from(ProductView::class, 'p');

        $qb->where('p.userId = :userId')
            ->setParameter('userId', $userId);

        if ($name) {
            $qb->andWhere(
                $qb->expr()->like('p.name', $qb->expr()->literal('%' . $name . '%'))
            );
        }

        $qb->orderBy('p.name', 'asc');
        $qb->addOrderBy('p.producerName', 'asc');

        return $qb->getQuery()->getResult();
    }

    /** @inheritDoc */
    public function getOneByUser(string $id, string $userId): ProductView
    {
        $entity = $this->viewsEntityManager->getRepository(ProductView::class)->findOneBy([
            'id' => $id,
            'userId' => $userId,
        ]);

        if (!$entity) {
            throw new NotFoundException('Unable to find Product: ' . $id);
        }

        return $entity;
    }
}
