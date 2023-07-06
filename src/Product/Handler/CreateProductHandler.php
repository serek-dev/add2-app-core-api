<?php

declare(strict_types=1);


namespace App\Product\Handler;


use App\Product\Dto\CreateProductDtoInterface;
use App\Product\Factory\ProductFactory;
use App\Product\Persistence\Product\StoreProductInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class CreateProductHandler
{
    public function __construct(
        private readonly ProductFactory $productFactory,
        private readonly StoreProductInterface $storeProduct,
        private readonly MessageBusInterface $externalQueue
    ) {
    }

    public function __invoke(CreateProductDtoInterface $createProductDto): void
    {
        $product = $this->productFactory->create($createProductDto);

        foreach ($product->pullEvents() as $e) {
            $this->externalQueue->dispatch($e);
        }

        $this->storeProduct->store($product);
    }
}
