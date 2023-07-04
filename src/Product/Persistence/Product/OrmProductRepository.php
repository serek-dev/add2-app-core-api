<?php

declare(strict_types=1);


namespace App\Product\Persistence\Product;


use App\Product\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

final class OrmProductRepository implements FindProductByNameInterface, StoreProductInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function findByName(string $productName, ?string $producerName = null): ?Product
    {
        return null;
    }

    public function store(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }
}
