<?php

declare(strict_types=1);


namespace App\Product\Entity;


use App\Product\Exception\InvalidArgumentException;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('product_meal')]
final class Meal
{
    /**
     * @param MealProduct[] $products
     */
    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private readonly string $id,
        #[Column]
        private readonly string $name,
        private readonly array $products,
    ) {
        foreach ($this->products as $p) {
            if (!$p instanceof MealProduct) {
                throw new InvalidArgumentException('Argument must be a: ' . MealProduct::class . ' instance');
            }
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return MealProduct[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
