<?php

declare(strict_types=1);


namespace App\Catalog\Handler;


use App\Catalog\Dto\CreateProductDtoInterface;
use App\Catalog\Factory\ProductFactory;
use App\Catalog\Persistence\Product\ProductPersistenceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateProductHandler
{
    public function __construct(private readonly ProductFactory $productFactory, private readonly ProductPersistenceInterface $storeProduct)
    {
    }

    public function __invoke(CreateProductDtoInterface $createProductDto): void
    {
        $product = $this->productFactory->create($createProductDto);

        $this->storeProduct->store($product);
    }
}
