<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog;


use App\Product\Entity\Product;
use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;
use App\Tests\Application\ApplicationTestCase;

abstract class CatalogTestCase extends ApplicationTestCase
{
    protected const MILK = 'p-64abe79bdf370';
    protected const WHEY_PROTEIN = 'p-64ac15aa30df8';
    protected const EGG = 'p-64abe7897e3c8';
    protected const OLIVE = 'p-sa23asda123';
    protected const OAT_BRAN = 'p-sa23asda321';

    protected function withMilkCatalogProduct(): self
    {
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

    protected function withWheyProteinProduct(): self
    {
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

    protected function withEggProduct(): self
    {
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

    protected function withOliveProduct(): self
    {
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

    protected function withOatBran(): self
    {
        $wheyProtein = new Product(
            self::OAT_BRAN,
            new NutritionalValues(
                new Weight(17.0),
                new Weight(66.0),
                new Weight(7.0),
                425.0,
            ),
            'Oat bran',
            'Sante',
        );

        $this->em->persist($wheyProtein);
        $this->em->flush();

        return $this;
    }
}
