<?php

declare(strict_types=1);


namespace App\Product\ViewQuery\Product;


use App\Product\Entity\Product;
use App\Product\Exception\NotFoundException;
use App\Product\View\MealProductView;
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
            $view = new MealProductView();

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

    /** @inheritDoc */
    public function getOne(string $id): MealProductView
    {
        $entity = $this->em->getRepository(Product::class)->find($id);

        if (!$entity) {
            throw new NotFoundException('Unable to find Product: ' . $id);
        }

        $view = new MealProductView();
        $v = $entity->getNutritionValues();

        $view->setId($entity->getId())
            ->setName($entity->getName())
            ->setProducerName($entity->getProducerName())
            ->setCarbs($v->getCarbs())
            ->setProteins($v->getProteins())
            ->setFats($v->getFats())
            ->setKcal($v->getKcal());

        return $view;
    }
}
