<?php

declare(strict_types=1);


namespace App\Product\ViewQuery\Product;


use App\Product\Exception\NotFoundException;
use App\Product\View\ProductView;
use Doctrine\ORM\EntityManagerInterface;

final class OrmProductRepository implements FindProductsInterface
{

    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /** @inheritDoc */
    public function findAll(?string $name = null): array
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('p')
            ->from(ProductView::class, 'p');

        if ($name) {
            $qb->where(
                $qb->expr()->like('p.name', $qb->expr()->literal('%' . $name . '%'))
            );
        }

        $qb->orderBy('p.name', 'asc');
        $qb->addOrderBy('p.producerName', 'asc');

        return $qb->getQuery()->getResult();
    }

    /** @inheritDoc */
    public function getOne(string $id): ProductView
    {
        $entity = $this->em->getRepository(ProductView::class)->find($id);

        if (!$entity) {
            throw new NotFoundException('Unable to find Product: ' . $id);
        }

        return $entity;
    }
}
