<?php

declare(strict_types=1);


namespace App\Catalog\Entity;


use App\Catalog\Exception\InvalidArgumentException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('p_meal')]
final class Meal
{
    #[OneToMany(mappedBy: 'meal', targetEntity: MealProduct::class, cascade: ['PERSIST'], fetch: "EAGER")]
    private mixed $products;

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
        array $products,
    ) {
        foreach ($products as $p) {
            if (!$p instanceof MealProduct) {
                throw new InvalidArgumentException('Argument must be a: ' . MealProduct::class . ' instance');
            }
            $p->setMeal($this);
        }

        $this->products = new ArrayCollection($products);
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
        return $this->products->toArray();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
