<?php

declare(strict_types=1);


namespace App\Product\ViewQuery\Product;


use App\Product\Entity\Product;
use App\Product\View\ProductView;
use Doctrine\ORM\EntityManagerInterface;

final class DbalProductRepository implements FindProductsInterface
{

    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /** @inheritDoc */
    public function findAll(?string $name = null): array
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('p')
            ->from(Product::class, 'p');

        if ($name) {
            $qb->where(
                $qb->expr()->like('p.name', $qb->expr()->literal('%' . $name . '%'))
            );
        }

        $qb->orderBy('p.name', 'asc');
        $qb->addOrderBy('p.producerName', 'asc');

        return array_map(function (array $row) {
            $view = new ProductView();

            $view->setId($row['id'])
                ->setName($row['name'])
                ->setProducerName($row['producerName'])
                ->setCarbs($row['carbs'])
                ->setProteins($row['proteins'])
                ->setFats($row['fats'])
                ->setKcal($row['kcal']);

            return $view;
        },
            $qb
                ->getQuery()
                ->getArrayResult());
    }
}
