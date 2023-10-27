<?php

declare(strict_types=1);


namespace App\Catalog\Handler;


use App\Catalog\Dto\UpdateProductDtoInterface;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Persistence\Product\ProductPersistenceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateProductHandler
{
    public function __construct(private readonly FindProductByIdInterface $find, private readonly ProductPersistenceInterface $storeProduct)
    {
    }

    public function __invoke(UpdateProductDtoInterface $command): void
    {
        $product = $this->find->findById($command->getId());

        if ($product === null) {
            throw new NotFoundException('Product not found');
        }

        $product->setNutritionalValues($command->getNutritionValues());
        $product->setName($command->getName());
        $product->setProducerName($command->getProducerName());

        $this->storeProduct->store($product);
    }
}
