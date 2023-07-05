<?php

declare(strict_types=1);


namespace App\Product\Persistence\Product;


use App\Product\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class OrmProductRepository implements FindProductByNameInterface, StoreProductInterface, FindProductByIdInterface
{
    private ObjectRepository $repository;

    public function __construct(private readonly EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(Product::class);
    }

    public function findByName(string $productName, ?string $producerName = null): ?Product
    {
        return null; // todo:
    }

    public function store(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function findById(string $id): ?Product
    {
        return $this->repository->find($id);
    }
}
