<?php

namespace App\Catalog\Handler;

use App\Catalog\Dto\RemoveProductDtoInterface;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Persistence\Product\ProductPersistenceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RemoveProductHandler
{
    public function __construct(
        private readonly FindProductByIdInterface    $findProductById,
        private readonly ProductPersistenceInterface $persistence,
    )
    {
    }

    public function __invoke(RemoveProductDtoInterface $dto): void
    {
        $product = $this->findProductById->findById($dto->getId());

        if (!$product) {
            throw new NotFoundException('Product: ' . $dto->getId() . ' does not exist');
        }

        $this->persistence->remove($product);
    }
}