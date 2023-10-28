<?php

declare(strict_types=1);


namespace App\Catalog\Persistence\Product;


use App\Catalog\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class OrmProductPersistenceRepository implements FindProductByNameInterface, ProductPersistenceInterface, FindProductByIdInterface
{
    private ObjectRepository $repository;

    public function __construct(private readonly EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(Product::class);
    }

    public function findByName(string $productName, ?string $producerName = null): ?Product
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('p')
            ->from(Product::class, 'p');

        $qb->where('p.name = :name');
        $qb->setParameter('name', $productName);


        if (!empty($producerName)) {
            $qb->andWhere('p.producerName = :producerName');
            $qb->setParameter('producerName', $producerName);
        } else {
            $qb->andWhere('p.producerName is NULL');
        }

        $qb->setMaxResults(1);

        return $qb->getQuery()->getResult()[0] ?? null;
    }

    public function store(Product ...$product): void
    {
        foreach ($product as $p) {
            $this->em->persist($p);
        }
        $this->em->flush();
    }

    public function findById(string $id): ?Product
    {
        return $this->repository->find($id);
    }

    public function remove(Product $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }
}
