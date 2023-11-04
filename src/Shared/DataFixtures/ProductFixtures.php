<?php

declare(strict_types=1);

namespace App\Shared\DataFixtures;

use App\Catalog\Command\CreateProductCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\MessageBusInterface;

final class ProductFixtures extends Fixture
{
    public const PRODUCT_1 = 'P-1';
    public const PRODUCT_2 = 'P-2';

    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // RemoveProductControllerTest

        [$p, $f, $c, $k] = $this->getNutritionValues(10, 20, 10);
        $command = new CreateProductCommand(
            name: 'Product 1',
            proteins: $p,
            fats: $f,
            carbs: $c,
            kcal: $k,
            producerName: null,
            id: self::PRODUCT_1,
            unit: 'szt.',
            weightPerUnit: 50,
        );

        $this->bus->dispatch($command);

        // UpdateProductControllerTest

        [$p, $f, $c, $k] = $this->getNutritionValues(1, 1, 1);
        $command = new CreateProductCommand(
            name: 'Product 2',
            proteins: $p,
            fats: $f,
            carbs: $c,
            kcal: $k,
            producerName: null,
            id: self::PRODUCT_2,
            unit: null,
            weightPerUnit: null,
        );

        $this->bus->dispatch($command);
    }

    private function getNutritionValues(float $proteins, float $fats, float $carbs): array
    {
        return [$proteins, $fats, $carbs, $proteins * 4 + $fats * 9 + $carbs * 4];
    }
}
