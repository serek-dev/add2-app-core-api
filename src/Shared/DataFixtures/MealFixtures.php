<?php

declare(strict_types=1);

namespace App\Shared\DataFixtures;

use App\Catalog\Command\CreateMealCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\MessageBusInterface;

final class MealFixtures extends Fixture implements DependentFixtureInterface
{
    public const MEAL_1 = 'M-1';

    public const MEAL_1_MEAL_PRODUCT_1 = 'M-1-P-1';


    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // RemoveProductControllerTest
        // RemoveDayMealProductControllerTest

        $command = new CreateMealCommand(
            name: 'Meal 1',
            products: [
                [
                    'id' => ProductFixtures::PRODUCT_1, 'weight' => 100,
                ],
            ],
            id: self::MEAL_1,
        );
        $this->bus->dispatch($command);
    }

    public function getDependencies()
    {
        return [
            ProductFixtures::class,
        ];
    }
}
