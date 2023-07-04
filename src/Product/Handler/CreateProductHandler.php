<?php

declare(strict_types=1);


namespace App\Product\Handler;


use App\Product\Dto\CreateProductDtoInterface;
use App\Product\Factory\ProductFactory;
use App\Product\Repository\Product\StoreProductInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateProductHandler
{
    public function __construct(private readonly ProductFactory $productFactory, private readonly StoreProductInterface $storeProduct)
    {
    }

    public function __invoke(CreateProductDtoInterface $createProductDto): void
    {
        $product = $this->productFactory->create($createProductDto);

        $this->storeProduct->store($product);
    }
}
