<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog;


use App\Product\Builder\MealBuilder;
use App\Product\Entity\Meal;
use App\Product\Entity\Product;
use App\Product\Persistence\Product\FindProductByIdInterface;
use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;
use App\Tests\Application\ApplicationTestCase;
use Doctrine\Persistence\ObjectRepository;

abstract class CatalogTestCase extends ApplicationTestCase
{
    protected const MILK = 'p-64abe79bdf370';
    protected const WHEY_PROTEIN = 'p-64ac15aa30df8';
    protected const EGG = 'p-64abe7897e3c8';
    protected const OLIVE = 'p-sa23asda123';
    protected const OAT_BRAN = 'p-sa23asda321';

    protected const PANCAKE = 'M-64f6031add8ee';

    protected function withMilk(): self
    {
        if ($this->productExists(self::MILK)) {
            return $this;
        }

        $milk = new Product(
            self::MILK,
            new NutritionalValues(
                new Weight(3.40),
                new Weight(2.0),
                new Weight(4.90),
                51.0,
            ),
            'Milk',
            null,
        );

        $this->em->persist($milk);
        $this->em->flush();

        return $this;
    }

    protected function withWheyProtein(): self
    {
        if ($this->productExists(self::WHEY_PROTEIN)) {
            return $this;
        }

        $wheyProtein = new Product(
            self::WHEY_PROTEIN,
            new NutritionalValues(
                new Weight(80.0),
                new Weight(3.0),
                new Weight(2.20),
                356.0,
            ),
            'Whey Protein',
            'Olimp',
        );

        $this->em->persist($wheyProtein);
        $this->em->flush();

        return $this;
    }

    protected function withEgg(): self
    {
        if ($this->productExists(self::EGG)) {
            return $this;
        }

        $wheyProtein = new Product(
            self::EGG,
            new NutritionalValues(
                new Weight(12.50),
                new Weight(9.7),
                new Weight(0.6),
                140.0,
            ),
            'Egg',
            null,
        );

        $this->em->persist($wheyProtein);
        $this->em->flush();

        return $this;
    }

    protected function withOlive(): self
    {
        if ($this->productExists(self::OLIVE)) {
            return $this;
        }

        $wheyProtein = new Product(
            self::OLIVE,
            new NutritionalValues(
                new Weight(0.0),
                new Weight(99.6),
                new Weight(0.2),
                897.0,
            ),
            'Olive',
            null,
        );

        $this->em->persist($wheyProtein);
        $this->em->flush();

        return $this;
    }

    private function productExists(string $id): bool
    {
        /** @var ObjectRepository $repo */
        $repo = $this->em->getRepository(Product::class);

        return !empty($repo->find($id));
    }

    private function mealExists(string $name): bool
    {
        /** @var ObjectRepository $repo */
        $repo = $this->em->getRepository(Meal::class);

        return !empty($repo->findOneBy(['name' => $name]));
    }

    protected function withOatBran(): self
    {
        if ($this->productExists(self::OAT_BRAN)) {
            return $this;
        }

        $wheyProtein = new Product(
            self::OAT_BRAN,
            new NutritionalValues(
                new Weight(17.0),
                new Weight(7.0),
                new Weight(66.0),
                425.0,
            ),
            'Oat bran',
            'Sante',
        );

        $this->em->persist($wheyProtein);
        $this->em->flush();

        return $this;
    }

    protected function withPancakeMeal(): self
    {
        if ($this->mealExists('Pancake')) {
            return $this;
        }

        $this->withOatBran()
            ->withMilk()
            ->withOlive()
            ->withWheyProtein()
            ->withEgg();

        /** @var MealBuilder $builder */
        $builder = self::getContainer()->get(MealBuilder::class);

        /** @var FindProductByIdInterface $repo */
        $repo = self::getContainer()->get(FindProductByIdInterface::class);

        $builder->addProduct(
            new Weight(10.0),
            $repo->findById(self::OAT_BRAN)
        );
        $builder->addProduct(
            new Weight(35.0),
            $repo->findById(self::WHEY_PROTEIN)
        );
        $builder->addProduct(
            new Weight(5.0),
            $repo->findById(self::OLIVE)
        );
        $builder->addProduct(
            new Weight(56.0),
            $repo->findById(self::EGG)
        );
        $builder->addProduct(
            new Weight(100.0),
            $repo->findById(self::MILK)
        );

        $meal = $builder->withId(self::PANCAKE)->build('Pancake');

        $this->em->persist($meal);
        $this->em->flush();

        return $this;
    }
}
