<?php

declare(strict_types=1);

namespace App\Catalog\Handler;

use App\Catalog\Command\CreateProductCommand;
use App\Catalog\Dto\UploadProductsDtoInterface;
use App\Catalog\Factory\ProductFactory;
use App\Catalog\Persistence\Product\ProductPersistenceInterface;
use App\Catalog\Utils\XlsToArrayInterface;
use DomainException;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UploadProductsHandler
{
    private const ID_COL = 0;
    private const NAME_COL = 1;
    private const PRODUCER_COL = 2;
    private const PROTEINS_COL = 3;
    private const FATS_COL = 4;
    private const CARBS_COL = 5;
    private const KCAL_COL = 6;
    private const ID_UNIT = 7;

    private const ID_UNIT_PER_WEIGHT = 8;

    public function __construct(
        private readonly XlsToArrayInterface         $converter,
        private readonly ProductFactory              $factory,
        private readonly ProductPersistenceInterface $persistence,
        private readonly LoggerInterface             $logger,
    )
    {
    }

    public function __invoke(UploadProductsDtoInterface $dto): void
    {
        $data = $this->converter->normalize($dto->getFile()->getContent());

        $created = [];

        foreach ($data as $productData) {
            try {
                $created[] = $this->factory->create(
                    createProductDto: new CreateProductCommand(
                        name: $productData[self::NAME_COL],
                        proteins: (float)$productData[self::PROTEINS_COL],
                        fats: (float)$productData[self::FATS_COL],
                        carbs: (float)$productData[self::CARBS_COL],
                        kcal: (float)$productData[self::KCAL_COL],
                        userId: $dto->getUserId(),
                        producerName: $productData[self::PRODUCER_COL],
                        id: $productData[self::ID_COL],
                        unit: null, //$productData[self::ID_UNIT], // todo
                        weightPerUnit: null, // $productData[self::ID_UNIT_PER_WEIGHT],
                    ));
            } catch (DomainException|InvalidArgumentException $e) {
                $this->logger->warning($e->getMessage());
                continue;
            }
        }

        $this->persistence->store(...$created);
    }
}