<?php

declare(strict_types=1);


namespace App\Catalog\Handler;


use App\Catalog\Dto\UpdateProductDtoInterface;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Persistence\Product\ProductPersistenceInterface;
use App\Catalog\Specification\ProductSpecificationInterface;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final class UpdateProductHandler
{
    /**
     * @param ProductSpecificationInterface[] $specifications
     */
    public function __construct(
        private readonly FindProductByIdInterface    $find,
        private readonly ProductPersistenceInterface $storeProduct,
        private readonly iterable                    $specifications = [],

    )
    {
        foreach ($this->specifications as $s) {
            if (!$s instanceof ProductSpecificationInterface) {
                throw new RuntimeException(
                    'Specification should implement ProductSpecificationInterface'
                );
            }
        }
    }

    /**
     * @throws Throwable
     */
    public function __invoke(UpdateProductDtoInterface $command): void
    {
        $product = $this->find->findById($command->getId());

        if ($product === null) {
            throw new NotFoundException('Product not found');
        }

        $product->setNutritionalValues($command->getNutritionValues());
        $product->setName($command->getName());
        $product->setProducerName($command->getProducerName());
        $product->setPortion($command->getPortion());

        foreach ($this->specifications as $spec) {
            $spec->isSatisfiedBy($product);
        }

        $this->storeProduct->store($product);
    }
}
